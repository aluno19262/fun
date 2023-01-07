<?php

namespace App\Observers;

use App\Facades\Moloni;
use App\Models\Associate;
use App\Models\Declaration;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Quota;
use App\Models\User;
use App\Notifications\DeclarationActive;
use App\Notifications\DeclarationPayed;
use App\Notifications\DeclarationPayedAdmin;
use App\Notifications\DeclarationWaitingPayment;
use App\Notifications\EvaluationActive;
use App\Notifications\NoNifOrder;
use App\Notifications\OrderWithRemaining;
use App\Notifications\QuotaPayed;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //

    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //

    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "saving" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function saved(Order $order)
    {
        debugbar()->error('Entrou no observer');
        $isInscription = false;
        $isQuotaPayment = false;
        //if the order changed to payed and is an order with the payment of a quota then update the quota_valid_until on the associate
        if($order->getOriginal('status') != Order::STATUS_PAYED && $order->status == Order::STATUS_PAYED) {
            debugbar()->error('Status waiting payment');
            //if is the order of inscription then do somethings like generate number
            if (Associate::where('evaluation_order_id', $order->id)->exists()) {
                $order->associate->status = Associate::STATUS_ACTIVE;
                $order->associate->registration_date = Carbon::today();
                $order->associate->associate_number = Associate::getNextAssociateNumber($order->associate->category);
                if ($order->associate->category == Associate::CATEGORY_ASSOCIADO_ESTUDANTE) {
                    $order->associate->registration_date = Carbon::today();
                    $order->associate->quota_valid_until = Carbon::createFromFormat('d-m-Y', '31-01-' . Carbon::today()->addYear()->year);
                    //$order->associate->quota_valid_until = Carbon::createFromFormat('d-m-Y','31-01-' . Associate::getQuotaYearForCreate($order->associate));
                    $inscriptionFeeItem = $order->orderItems()->whereNull('quota_id')->first(); // get the joia
                    if (!empty($inscriptionFeeItem)) {
                        $order->associate->inscription_fee_payed = $inscriptionFeeItem->price;
                    }
                }

                $order->associate->saveQuietly();
                $isInscription = true;
            }

            //send notification if a quota was payed but only if it is not the inscription
            \Debugbar::error($order->orderItems, $order->orderItems()->whereNull('quota_id')->first(), $order->orderItems()->whereNotNull('quota_id')->first());
            if (empty($order->orderItems()->whereNull('quota_id')->first()) && !empty($order->orderItems()->whereNotNull('quota_id')->first())) {
                \Debugbar::error('entrou');
                $order->associate->notify(new QuotaPayed($order));
            }

            /*dd($order->orderItems);*/
            $generateSeguroFlag = false;
            debugbar()->error("items",count($order->orderItems));
            //make all orders items as payed
            foreach ($order->orderItems as $item) {
                \Debugbar::error('passa 2 vezes aqui');
                $item->status = OrderItem::STATUS_PAYED;
                $item->save();
                \Debugbar::error("antes do valid",!empty($order->associate) , !empty($order->quota));
                //if the item is a quota updade the quota valid until
                if (!empty($item->associate) && !empty($item->quota)) {
                    $validUntil = $item->quota->validUntil();
                    $item->quota->status = Quota::STATUS_ACTIVE;
                    $item->quota->save();
                    debugbar()->error("tem valid e a quota",$validUntil,$order->associate->quota_valid_until);
                    if (empty($order->associate->quota_valid_until) || $order->associate->quota_valid_until->lessThan($validUntil)) {
                        $order->associate->quota_valid_until = $validUntil;
                        $order->associate->saveQuietly();
                        $generateSeguroFlag = true;
                        debugbar()->error("Deve mandar criar seguro");
                    }
                } elseif (!empty($item->declaration)) { // is a declaration
                    debugbar()->error('é uma declaração');
                    $declaration = $item->declaration;
                    if($declaration->is_renovation){
                        $declaration->status = Declaration::STATUS_WAITING_APPROVAL;
                    }else{
                        $declaration->status = Declaration::STATUS_ACTIVE;
                        $declaration->setDeclarationToActive(false,true);
                    }
                    debugbar()->error("vai guardar");
                    if ($declaration->save()) {
                        /*debugbar()->error("guardou $declaration->id");
                        $declaration->getFinalDocument(false);*/
                        debugbar()->error("is renovation " . $declaration->is_renovation ? "true" : "false");
                        if($declaration->is_renovation){
                            $order->associate->notify(new DeclarationPayed($order, $declaration));
                            if(\App\Facades\Setting::getParam('send_staff_mails')){
                                $admins = User::where('email', '!=', "apoio.tecnico@apap.pt")->whereHas(
                                    'roles', function ($q) {
                                    $q->where('name', 'Staff');
                                })->get();
                                foreach ($admins as $admin) {
                                    $admin->notify(new DeclarationPayedAdmin($order, $declaration));
                                }
                            }
                        }else{
                            $order->associate->notify(new DeclarationActive($declaration));
                        }


                    } else {
                        flash()->error(__('Something went wrong. Please try again.'))->overlay();
                    }
                }
            }
            if ($generateSeguroFlag && $order->associate->quota_valid_until->gte(Carbon::today())) {
                debugbar()->error("Vai gerar seguro");
                //generate the declaracao de seguro after a quota being payed
                $seguro = $order->generateDeclaracaoSeguro();
                if ($isInscription && !empty($seguro)) {
                    $order->associate->notify(new EvaluationActive($seguro, $order));
                }
            }

            $newOrder = $order->associate->generateQuota(null,0,null,false);
            if(!empty($newOrder)){
                //TODO notificar que tem uma nova order com o remanescente para pagar
                $newOrder->associate->notify( new OrderWithRemaining($newOrder,$newOrder->associate));
            }

        }

        //send notification about a declaration waiting payment
        if($order->status == Order::STATUS_WAITING_PAYMENT && $order->orderItems()->whereNotNull('declaration_id')->exists()){
            $order->associate->notify(new DeclarationWaitingPayment($order,$order->orderItems()->whereNotNull('declaration_id')->first()->declaration));
        }

        if(($order->status == Order::STATUS_REMOVED && $order->getOriginal('status') !== Order::STATUS_REMOVED) || ($order->status == Order::STATUS_CANCELED && $order->getOriginal('status') !== Order::STATUS_CANCELED)){
            foreach ($order->orderItems as $item){
                $item->status = OrderItem::STATUS_CANCELED;
                $item->save();
                debugbar()->error(!empty($item->quota),!empty($item->declaration));
                if(!empty($item->quota)){
                    $item->quota->status =Quota::STATUS_CANCELED;
                    $item->quota->save();
                }
                if(!empty($item->declaration)){
                    $item->declaration->status = Declaration::STATUS_INACTIVE;
                    $item->declaration->save();
                }
            }
        }



        //only generate the invoice if the vat exists
        if(!empty($order->vat)) {
            //TODO ativar a parte de faturar automatico
            if ($order->invoice_status == Order::INVOICE_STATUS_WAITING_EMISSION && $order->status == Order::STATUS_PAYED) {
                if (!Moloni::isTokenValid()) {
                    Moloni::login();
                    //\Debugbar::info("faz login");
                }
                \Debugbar::error('no observer invoice');
                $order->createInvoice();
            }
        }elseif($order->getOriginal('status') == Order::STATUS_WAITING_PAYMENT && $order->status == Order::STATUS_PAYED){
            \Debugbar::error('Não faturou porque não tinha nif');
            $admins = User::where('email', '!=', "apoio.tecnico@apap.pt")->whereHas(
                'roles', function ($q) {
                $q->where('name', 'Staff');
            })->get();
            foreach ($admins as $admin) {
                $admin->notify(new NoNifOrder($order,$admin));
            }

        }
    }
}

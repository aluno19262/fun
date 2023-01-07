<?php

namespace App\Http\Controllers;

use App\DataTables\OrderDataTable;
use App\Facades\Moloni;
use App\Models\Associate;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Quota;
use App\Models\User;
use App\Notifications\NoNifOrder;
use App\Notifications\QuotasWaitingPayment;
use Carbon\Carbon;
use DvK\Laravel\Vat\Rules\VatNumber;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateOrderRequest;
//use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Squarebit\PTRules\Rules\BI;
use Squarebit\PTRules\Rules\CC;
use Squarebit\PTRules\Rules\NIF;

class OrderController extends Controller
{
    /**
     * Display a listing of the Order.
     *
     * @param OrderDataTable $orderDataTable
     * @return Response
     */
    public function index(OrderDataTable $orderDataTable,Request $request)
    {
        if(auth()->user()->can('manageApp') && !empty($request['associate_id'])){
            $associate = Associate::findOrFail($request['associate_id']);
        }elseif(auth()->user()->can('manageApp') && empty($request['associate_id'])) {
            $associate = null;
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }

        return $orderDataTable->render('orders.index',compact('associate'));
    }

    /**
     * Show the form for creating a new Order.
     *
     * @return Response
     */
    public function create()
    {
        $order = new Order();
        $order->loadDefaultValues();
        return view('orders.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->vat)){
            $request->merge(['vat' => str_replace(" ","",$request->vat)]);
        }
        $validatedAttributes = $this->validateForm($request);

        if(($model = Order::create($validatedAttributes)) ) {
            flash(__('Order saved successfully.'))->overlay()->success();
            //Flash::success('Order saved successfully.');
            return redirect(route('orders.show', $model));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified Order.
     *
     * @param  Order  $order
     * @return Response
     */
    public function show(Order $order)
    {
        if(auth()->user()->can('manageApp') && !empty($request['associate_id'])){
            $associate = Associate::findOrFail($request['associate_id']);
        }elseif(auth()->user()->can('manageApp') && empty($request['associate_id'])) {
            $associate = null;
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        return view('orders.show', compact('order','associate'));
    }

    /**
     * Show the form for editing the specified Order.
     *
     * @param  Order $order
     * @return Response
     */
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified Order in storage.
     *
     * @param  Request  $request
     * @param  Order $order
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        if(!empty($request->vat)){
            $request->merge(['vat' => str_replace(" ","",$request->vat)]);
        }
        $validatedAttributes = $this->validateForm($request, $order);
        $order->fill($validatedAttributes);
        if($order->save()) {
            flash(__('Order updated successfully.'))->overlay()->success();
            //Flash::success('Order updated successfully.');
            return redirect(route('orders.show', $order));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified Order from storage.
      *
      * @param  \App\Models\Order  $order
      * @return Response
      */
    public function destroy(Order $order)
    {
        $order->delete();
        //Flash::success('Order deleted successfully.');

        return redirect(route('orders.index'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, Order $model = null): array
    {
        $validate_array = Order::rules();
        $validator = \Illuminate\Support\Facades\Validator::make(['vat' => $request->vat], ['vat' => ['required',new NIF()]]);
        if($validator->fails()){
            $validate_array['vat'] = ['required',new VatNumber()];
        }else{
            $validate_array['vat'] = ['required',new NIF()];
        }

        return $request->validate($validate_array, [], Order::attributeLabels());
    }



    /**
     * @param Request $request
     * @return bool
     */
    public function eupagoCallback(Request $request){
        $payment = new Payment();
        $payment->value = $request->get('valor', 0);
        $payment->setEupagoPaymentMethod($request->get('mp'));
        \Debugbar::error("Payment status".$payment->payment_method , Payment::PAYMENT_METHOD_MBWAY);
        $payment->transaction_id = $request->get('transacao');
        $payment->status = Payment::STATUS_PAYMENT_COMPLETED;

        $payment->raw_data = json_encode($request->toArray());
        $order = Order::find($request->get('identificador'));
        if($order->status == Order::STATUS_CANCELED){
            $admins = User::where('email', '!=', "apoio.tecnico@apap.pt")->whereHas(
                'roles', function ($q) {
                $q->where('name', 'Staff');
            })->get();
            foreach ($admins as $admin) {
                $admin->notify(new CanceledOrderPayed($order));
            }
        }
        $orderCompleted = false;
        if($order == null){
            \Debugbar::error("Order with id:".$request->get('identificador')." not found");
            $payment->currency = "EUR";
            $payment->save();
            \Debugbar::error("Payment without order created with id ".$payment->id);
        }else {
            $payment->order_id = $order->id;
            $payment->currency = "EUR";
            $orderHalf = false;
            \Debugbar::info($request->get('chave_api') ."==". config('eupago.key'));
            \Debugbar::info(floatval($order->total) ."==". floatval($request->get('valor', 0)));
            \Debugbar::info($request->get('referencia') ."==". $order->mb_ref);
            \Debugbar::info($request->get('referencia') ."==". $order->mbway_ref);
            if ($payment->payment_method == Payment::PAYMENT_METHOD_MB_REF || $payment->payment_method == Payment::PAYMENT_METHOD_UNKNOWN) {
                if (($request->get('chave_api') == config('eupago.key') &&
                    floatval($order->total) == floatval($request->get('valor', 0)) &&
                    $request->get('referencia') == $order->mb_ref) || ($request->get('chave_api') == config('eupago.key') &&
                        floatval($order->total_half) == floatval($request->get('valor', 0)) &&
                        $request->get('referencia') == $order->mb_ref_half)) {
                    $orderCompleted = true;
                    if(floatval($order->total_half) == floatval($request->get('valor', 0)) &&
                        $request->get('referencia') == $order->mb_ref_half){
                        $orderHalf = true;
                    }
                }
            } elseif ($payment->payment_method == Payment::PAYMENT_METHOD_MBWAY) {
                debugbar()->error($request->get('chave_api') == config('eupago.key'),floatval($order->total) == floatval($request->get('valor', 0)),$request->get('referencia') == $order->mbway_ref,floatval($order->total_half) == floatval($request->get('valor', 0)),$request->get('referencia') == $order->mbway_ref_half);
                if (($request->get('chave_api') == config('eupago.key') &&
                        floatval($order->total) == floatval($request->get('valor', 0)) &&
                        $request->get('referencia') == $order->mbway_ref) || ($request->get('chave_api') == config('eupago.key') &&
                        floatval($order->total_half) == floatval($request->get('valor', 0)) &&
                        $request->get('referencia') == $order->mbway_ref_half)) {
                    $orderCompleted = true;
                    if(floatval($order->total_half) == floatval($request->get('valor', 0)) &&
                        $request->get('referencia') == $order->mbway_ref_half){
                        $orderHalf = true;
                    }
                }
            }
            $payment->save();
            if($orderCompleted){
                //$payment->refresh();
                if($orderHalf){
                    \Debugbar::info("Altera porque só foi pago metade");
                    //set the order as half payed and update the order items to be a single semester instead of a annual quota
                    $order->updateToHalfPayedOrder();
                }
                $order->status = Order::STATUS_PAYED;
            }else{
                $order->status = Order::STATUS_CANCELED;
            }
            $order->payment_method = $payment->payment_method;
            debugbar()->error('GUARDOU A ORDER E DEVIA IR PARA O OBSERVER');
            $order->save();

            if($order->status == Order::STATUS_PAYED){
                \Debugbar::info("Payment of order $order->id successful ");
                //send notification to admin
            }else{
                \Debugbar::error("Payment with ref ".$request->get('referencia')." as failed ");
                //send notification to admin
            }
        }
        return true;
        // /orders/eupago-callback?valor=10.00000
        //&canal=Multibanco+testes
        //&referencia=100153903
        //&transacao=10398551
        //&identificador=4
        //&mp=
        //&chave_api=demo-eca9-f025-dca2-5f4
        //&data=2020-08-06:11:58:26
        //&entidade=82307
        //&comissao=0.86
        //&local=demo
    }

    public function payWithMBWay(Request $request){
        \Debugbar::error($request->all());
        $order = Order::where('id',$request['order_id'])->first();
        if(!empty($order)){
            $isHalf = $request['isHalf'];
            if (str_contains(substr($request['phone'],0,3),351)) {
                $phone =substr($request['phone'],2,9);
            }elseif(str_contains(substr($request['phone'],0,3),'+351')){
                $phone =substr($request['phone'],3,9);
            }else{
                $phone = $request['phone'];
            }
            $mbway = $order->generateMBWay($phone,$isHalf,'Pagamento APAP');

            if($mbway){
                if($isHalf == "0"){
                    return ['success' => true, 'mbway' => $order->mbway_alias , 'total' => $order->total];
                }else{
                    return ['success' => true, 'mbway' => $order->mbway_alias_half , 'total' => $order->total_half];
                }

            }else{
                return ['success' => false];
            }

        }
    }

    public function divideQuota(Order $order,Request $request){
        //vai buscar todos os items cujos produtos sejam relativos a quotas
        $items = $order->orderItems()->whereNotNull('quota_id')->with('quota')->get()->sortBy('quota.year');
        $associate = $order->associate;
        //generate an order
        $newOrder = Order::generateEmptyOrder($associate);
        $countQuotas = 0;
        foreach($items as $item){
            $quota = $item->quota;
            //se o item for de 1 quota anual, dividir as quotas em 2 semestres
            if(in_array($item->product_id,[2,8]) ){
                if($item->product_id == 2){
                    $product = Product::where('id',1)->first();
                }else{
                    $product = Product::where('id',7)->first();
                }
                $quota1 = Quota::createQuota($associate->id,$quota->year, 1, $product->price);
                $quota2 = Quota::createQuota($associate->id,$quota->year, 2, $product->price);
                if($countQuotas < $request['divide']){
                    //generate Quotas and add the quota item to the order
                    $newOrder->addItem($product,1,$quota1->id);
                    $countQuotas++;
                }
                if($countQuotas < $request['divide']){
                    //generate Quotas and add the quota item to the order
                    $newOrder->addItem($product,1,$quota2->id);
                    $countQuotas++;
                }
            }else{
                if($countQuotas < $request['divide']) {
                    $newQuota = $quota->replicate();
                    $newQuota->save();
                    $newOrder->addItem($item->product, 1, $newQuota->id);
                }else{
                    $newQuota = $quota->replicate();
                    $newQuota->save();
                }
                $countQuotas++;
            }

            $quota->status = Quota::STATUS_CANCELED;
            $quota->saveQuietly();
        }

        //adicionar à nova order a joia de inscrição caso exista
        if($order->orderItems()->whereIn('product_id',[3,4,5])->exists()){
            $joia = $order->orderItems()->whereIn('product_id',[3,4,5])->first();
            $joiaProduct = Product::where('id',$joia->product_id)->first();
            if(!empty($joiaProduct)){
                $newOrder->addItem($joiaProduct,1);
            }
        }

        $newOrder->calculateTotal();
        $newOrder->generateMB();
        $newOrder->save();
        if($associate->evaluation_order_id == $order->id){
            $associate->evaluation_order_id = $newOrder->id;
            $associate->saveQuietly();
        }
        $order->status = Order::STATUS_CANCELED;
        $order->save();
        return redirect()->route('orders.show',[$newOrder,'associate_id' => $associate]);
    }

    /**
     * Generate a invoice for the given order.
     *
     * @param  Order  $order
     * @return Response
     */
    public function generateInvoice(Order $order)
    {
        //$this->authorize('createInvoice', Order::class);
        if(!Moloni::isTokenValid()){
            Moloni::login();
            \Debugbar::info("faz login");
        }
        if($order->invoice_status == Order::INVOICE_STATUS_WAITING_EMISSION){
            $order->createInvoice();
        }
        return redirect()->back();
    }

    /**
     * Generate a invoice for the given order.
     *
     * @param  Order  $order
     * @return Response
     */
    public function generateInvoiceDatatable(Order $order)
    {
        //$this->authorize('createInvoice', Order::class);
        if(!Moloni::isTokenValid()){
            Moloni::login();
            \Debugbar::info("faz login");
        }
        if($order->invoice_status == Order::INVOICE_STATUS_WAITING_EMISSION){
            $order->createInvoice();
        }
        return redirect()->back();
    }

    public function generateQuotas(Request $request){
        //dd($request->all());
        if(!empty($request->associate)){
            $associate = Associate::where('id',$request->associate)->first();
            if(!empty($associate)){
                $order = Order::generateEmptyOrder($associate); // create a new empty order

                $semester = $request->start_semester;
                $currentYear = $request->initial_year;
                $quotaProduct = $associate->getQuotaProduct($semester);
                for($i = 0; $i < $request->end_semester; $i++){
                    if(!Quota::where('associate_id',$associate->id)->where('year',$currentYear)->whereIn('semester',[0,$semester])->where('status',Quota::STATUS_ACTIVE)->exists()){
                        //generate a quota
                        $quota = Quota::createQuota($associate->id,$currentYear, $semester, !empty($quotaProduct) ? $quotaProduct->price : 0);
                        //added the quota item to the order
                        $order->addItem($quotaProduct,1,!empty($quota) ? $quota->id: null);
                    }else{
                        $order->delete();
                        flash()->error('Tentou gerar quotas já existentes no sistema.')->overlay();
                        return redirect()->back();
                    }

                    debugbar()->error("Semestre - $semester");
                    debugbar()->error("Ano - $currentYear");
                    if($semester == 1){
                        $semester = 2;
                    }else{
                        $semester = 1;
                        $currentYear++;
                    }
                }

                //update the total of the order
                $order->calculateTotal();
                $order->generateMB();
                $order->saveQuietly();
                if (!empty($order)) {
                    $associate->user->notify(new QuotasWaitingPayment($associate, $order));
                }
            }

            flash()->success('Foi gerado um novo pagamento de quotas com sucesso.')->overlay();
            return redirect()->back();
        }
        flash()->error('Ocorreu um erro. Tente novamente.')->overlay();
        return redirect()->back();

    }

    public function joinAllDeclarations(Request $request){
        $associate = Associate::where('id',$request['associate'])->first();
        if(!empty($associate)){
            $orders = $associate->orders()->where('status',Order::STATUS_WAITING_PAYMENT)->whereHas('orderItems',function ($q){
               $q->where('product_id',6);
            })->get();
            if(!empty($orders) && count($orders) > 1){
                $newOrder = Order::copyOrderItemsToNewOrder($orders,$associate);
                if(!empty($newOrder)){
                    flash()->success('Pagamento gerado com sucesso.')->overlay();
                    return redirect()->route('orders.show',[$newOrder,'associate_id' => $associate]);
                }
            }
        }
        flash()->error('Ocorreu um erro. Tente novamente mais tarde.')->overlay();
        return redirect()->back();
    }

    public function joinAllQuotas(Request $request){
        $associate = Associate::where('id',$request['associate'])->first();
        if(!empty($associate)){
            $orders = $associate->orders()->where('status',Order::STATUS_WAITING_PAYMENT)->whereHas('orderItems',function ($q){
                $q->whereIn('product_id',[1,2,3,4,7,8]);
            })->get();
            if(!empty($orders) && count($orders) > 1){
                $newOrder = Order::copyOrderItemsToNewOrder($orders,$associate);
                if(!empty($newOrder)){
                    flash()->success('Pagamento gerado com sucesso.')->overlay();
                    return redirect()->route('orders.show',[$newOrder,'associate_id' => $associate]);
                }
            }
        }
        flash()->error('Ocorreu um erro. Tente novamente mais tarde.')->overlay();
        return redirect()->back();
    }

    public function joinAllPayments(Request $request){
        $associate = Associate::where('id',$request['associate'])->first();
        if(!empty($associate)){
            $orders = $associate->orders()->where('status',Order::STATUS_WAITING_PAYMENT)->get();
            if(!empty($orders)){
                $newOrder = Order::copyOrderItemsToNewOrder($orders,$associate);
                if(!empty($newOrder)){
                    flash()->success('Pagamento gerado com sucesso.')->overlay();
                    return redirect()->route('orders.show',[$newOrder,'associate_id' => $associate]);
                }
            }
        }
        flash()->error('Ocorreu um erro. Tente novamente mais tarde.')->overlay();
        return redirect()->back();
    }


}

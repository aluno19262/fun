<?php

namespace App\Observers;

use App\Models\Associate;
use App\Models\FindAp;
use App\Models\User;
use App\Notifications\EvaluationActive;
use App\Notifications\EvaluationRejected;
use App\Notifications\EvaluationWaitingPayment;
use App\Notifications\NewAdminEvaluation;
use App\Notifications\NewBasicEvaluation;
use App\Notifications\NewCacEvaluation;
use App\Notifications\NewUser;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AssociateObserver
{
    /**
     * Handle the Associate "created" event.
     *
     * @param  \App\Models\Associate  $associate
     * @return void
     */
    public function created(Associate $associate)
    {

    }

    /**
     * Handle the Associate "updated" event.
     *
     * @param  \App\Models\Associate  $associate
     * @return void
     */
    public function updated(Associate $associate)
    {
        \Debugbar::error('associate updated',$associate);
        /*if($associate->getOriginal('name') != $associate->name || $associate->getOriginal('email') != $associate->email){
            $associate->user->name = $associate->name;
            $associate->user->email = $associate->email;
            $associate->user->save();
        }*/
        if($associate->getOriginal('status') != Associate::STATUS_REJECTED && $associate->status == Associate::STATUS_REJECTED){
            $associate->notify(new EvaluationRejected());
        }
        if($associate->getOriginal('status') != Associate::STATUS_WAITING_APPROVAL_CAC && $associate->status == Associate::STATUS_WAITING_APPROVAL_CAC){
            $cacs = User::whereHas('roles', function($q){
                $q->where('name', 'CAC');})->get();
            foreach($cacs as $cac){
                $cac->notify(new NewCacEvaluation($associate));
            }

        }
        if($associate->getOriginal('status') != Associate::STATUS_WAITING_ADMIN_APPROVAL && $associate->status == Associate::STATUS_WAITING_ADMIN_APPROVAL){
            $admins = User::whereHas('roles', function($q){
                $q->where('name', 'Direcção');})->get();
            foreach($admins as $admin){
                $admin->notify(new NewAdminEvaluation($associate));
            }

        }
        if($associate->getOriginal('status') != Associate::STATUS_WAITING_PAYMENT && $associate->status == Associate::STATUS_WAITING_PAYMENT){
            if($associate->generateInscriptionPayment(true)){
                $associate->notify(new EvaluationWaitingPayment($associate));
            }else{
                //mandar mail à administração devido a falha ao gerar pagamento de joia de inscrição + quotas
            }
        }

        if($associate->category == Associate::CATEGORY_ASSOCIADO_ESTUDANTE && $associate->getOriginal('status') == Associate::STATUS_INCOMPLETE_DATA && $associate->status == Associate::STATUS_WAITING_BASIC_APPROVAL){
            $associate->notify(new NewBasicEvaluation($associate,null));
            if(\App\Facades\Setting::getParam('send_staff_mails')){
                $secretariados = User::where('email', '!=', "apoio.tecnico@apap.pt")->whereHas('roles', function($q){
                    $q->where('name', 'Staff');})->get();
                foreach($secretariados as $secretariado){
                    $secretariado->notify(new NewBasicEvaluation($associate,$secretariado));
                }
            }

        }
        /*if($associate->getOriginal('status') != Associate::STATUS_ACTIVE && $associate->status == Associate::STATUS_ACTIVE){
            $declaration = $associate->declarations()->where('declaration_template_id',8)->first();
            $order = null;
            if(!empty($declaration)){
                dd($associate->orderItems()->where('declaration_id',$declaration->id)->get());
                $orderItem = $associate->orderItems()->where('declaration_id',$declaration->id)->first();
                if(!empty($orderItem)){
                    $order = $orderItem->order;
                }
            }
            dd($order,$declaration);
            if(!empty($declaration) && !empty($order)){
                $associate->notify(new EvaluationActive($declaration,$order));
            }

        }*/

        if(empty($associate->getOriginal('email')) && !empty($associate->email) && !empty($associate->name) && empty($associate->user_id)){
            $password = Str::random(16);
            $user = new User();
            $user->name = $associate->name;
            $user->email = $associate->email;
            $user->password = $password;
            if($user->save()){
                flash('Foi criado um utilizador para este associado com sucesso.')->overlay()->success();
                $associate->user_id = $user->id;
                $associate->saveQuietly();
                $user->assignRole('User');
                $user->notify(new NewUser($user,$password));
            }

        }


debugbar()->error("update e delete");
        if($associate->changedForMailChimpUpdate()){
            $associate->createOrUpdateMailchimpMember();
        }

        if($associate->changedForMailChimpDelete()){
            $associate->deleteMailchimpMember(false);
        }

    }

    /**
     * Handle the Associate "deleted" event.
     *
     * @param  \App\Models\Associate  $associate
     * @return void
     */
    public function deleted(Associate $associate)
    {
        //
    }

    /**
     * Handle the Associate "restored" event.
     *
     * @param  \App\Models\Associate  $associate
     * @return void
     */
    public function restored(Associate $associate)
    {
        //
    }

    /**
     * Handle the Associate "force deleted" event.
     *
     * @param  \App\Models\Associate  $associate
     * @return void
     */
    public function forceDeleted(Associate $associate)
    {
        //
    }

    /**
     * Handle the Associate "saving" event.
     *
     * @param  \App\Models\Associate  $associate
     * @return void
     */
    public function saving(Associate $associate)
    {
        if($associate->getOriginal('find_ap_enable') === false && $associate->find_ap_enable === true && !empty($associate->findAp) && $associate->findAp->status == FindAp::STATUS_INACTIVE ){
            $associate->findAp->status = FindAp::STATUS_ACTIVE;
            $associate->findAp->save();
        }
        if($associate->getOriginal('find_ap_enable') === true && $associate->find_ap_enable === false && !empty($associate->findAp) && $associate->findAp->status == FindAp::STATUS_ACTIVE ){
            $associate->findAp->status = FindAp::STATUS_INACTIVE;
            $associate->findAp->save();
        }
        if($associate->getOriginal('status') != Associate::STATUS_SUSPENDED && $associate->status == Associate::STATUS_SUSPENDED){
            $associate->suspended_at = Carbon::now();
        }elseif($associate->getOriginal('status') == Associate::STATUS_SUSPENDED && $associate->status != Associate::STATUS_SUSPENDED) {
            $associate->suspended_at = null;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\DataTables\AssociateDataTable;
use App\DataTables\AssociateInEvaluationDataTable;
use App\Models\AssociateEvaluation;
use App\Models\Company;
use App\Models\FindAp;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ContactCandidate;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use DvK\Laravel\Vat\Rules\VatNumber;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateAssociateRequest;
//use App\Http\Requests\UpdateAssociateRequest;
use App\Models\Associate;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Squarebit\PTRules\Rules\BI;
use Squarebit\PTRules\Rules\CC;
use Squarebit\PTRules\Rules\NIF;

class AssociateController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Associate::class, 'associate');
    }
    /**
     * Display a listing of the Associate.
     *
     * @param AssociateDataTable $associateDataTable
     * @return Response
     */
    public function index(AssociateDataTable $associateDataTable)
    {
        return $associateDataTable->render('associates.index');
    }

    public function inEvaluationIndex(AssociateInEvaluationDataTable $associateInEvaluationDataTable){
        return $associateInEvaluationDataTable->render('associates.in_evaluation_index');
    }

    /**
     * Show the form for creating a new Associate.
     *
     * @return Response
     */
    public function create()
    {
        $associate = new Associate();
        $associate->loadDefaultValues();
        return view('associates.create', compact('associate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validatedAttributes = $this->validateForm($request);

        if(($model = Associate::create($validatedAttributes)) ) {
            /*if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $model->addMediaFromRequest('image')->toMediaCollection('associate_profile');
            }*/
            if(!empty($request->get('image-base64', null))){
                $model->addMediaFromBase64($request->get('image-base64'))->toMediaCollection('associate_profile');
            }
            if ($request->hasFile('associate_cc') && $request->file('associate_cc')->isValid()) {
                $model->addMediaFromRequest('associate_cc')->toMediaCollection('associate_cc');
            }
            if ($request->hasFile('associate_passport') && $request->file('associate_passport')->isValid()) {
                $model->addMediaFromRequest('associate_passport')->toMediaCollection('associate_passport');
            }
            if ($request->hasFile('associate_curriculum') && $request->file('associate_curriculum')->isValid()) {
                $model->addMediaFromRequest('associate_curriculum')->toMediaCollection('associate_curriculum');
            }
            if ($request->hasFile('associate_degree_certificate') && $request->file('associate_degree_certificate')->isValid()) {
                $model->addMediaFromRequest('associate_degree_certificate')->toMediaCollection('associate_degree_certificate');
            }
            if ($request->hasFile('associate_master_certificate') && $request->file('associate_master_certificate')->isValid()) {
                $model->addMediaFromRequest('associate_master_certificate')->toMediaCollection('associate_master_certificate');
            }
            if ($request->hasFile('associate_degree_final_certificate') && $request->file('associate_degree_final_certificate')->isValid()) {
                $model->addMediaFromRequest('associate_degree_final_certificate')->toMediaCollection('associate_degree_final_certificate');
            }
            if ($request->hasFile('associate_master_final_certificate') && $request->file('associate_master_final_certificate')->isValid()) {
                $model->addMediaFromRequest('associate_master_final_certificate')->toMediaCollection('associate_master_final_certificate');
            }
            if ($request->hasFile('associate_degree_inscription_certificate') && $request->file('associate_degree_inscription_certificate')->isValid()) {
                $model->addMediaFromRequest('associate_degree_inscription_certificate')->toMediaCollection('associate_degree_inscription_certificate');
            }
            if ($request->hasFile('associate_master_inscription_certificate') && $request->file('associate_master_inscription_certificate')->isValid()) {
                $model->addMediaFromRequest('associate_master_inscription_certificate')->toMediaCollection('associate_master_inscription_certificate');
            }
            if ($request->hasFile('associate_bolonha_degree') && $request->file('associate_bolonha_degree')->isValid()) {
                $model->addMediaFromRequest('associate_bolonha_degree')->toMediaCollection('associate_bolonha_degree');
            }
            if ($request->hasFile('associate_bolonha_degree_inscription_certificate') && $request->file('associate_bolonha_degree_inscription_certificate')->isValid()) {
                $model->addMediaFromRequest('associate_bolonha_degree_inscription_certificate')->toMediaCollection('associate_bolonha_degree_inscription_certificate');
            }
            if(!empty($request['company_name'])){
                Company::createAssociateCompany($model,$request['company_name'],$request['company_email'],$request['company_address'],$request['company_zip'],$request['company_location'],$request['company_paris'],$request['company_municipality'],$request['company_district'],$request['company_country'],$request['company_vat'],$request['company_status']);
            }
            if(!empty($request['find_ap_name'])){
                FindAp::createAssociateFindAp($model,$request['find_ap_name'],$request['find_ap_email'],$request['find_ap_address'],$request['find_ap_phone'],$request['find_ap_status']);
            }
            flash(__('Associate saved successfully.'))->overlay()->success();
            //Flash::success('Associate saved successfully.');
            return redirect(route('home'));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified Associate.
     *
     * @param  Associate  $associate
     * @return Response
     */
    public function show(Associate $associate)
    {
        return view('associates.show', compact('associate'));
    }

    /**
     * Show the form for editing the specified Associate.
     *
     * @param  Associate $associate
     * @return Response
     */
    public function edit(Associate $associate)
    {
        return view('associates.edit', compact('associate'));
    }

    /**
     * Update the specified Associate in storage.
     *
     * @param  Request  $request
     * @param  Associate $associate
     * @return Response
     */
    public function update(Request $request, Associate $associate)
    {
        //dd($request->all());
        $validatedAttributes = $this->validateForm($request, $associate);
        $associate->fill($validatedAttributes);
        if($associate->save()) {
            /*if($request->hasFile('image') && $request->file('image')->isValid()){
                $associate->addMediaFromRequest('image')->toMediaCollection('associate_profile');
            }elseif($request->filled('delete_image') && $request->boolean('delete_image')){ // if the image was replaced above it will automatically delete this so don't run again
                $associate->getFirstMedia('associate_profile')->delete();
            }*/
            if(!empty($request->get('image-base64', null))){
                $associate->addMediaFromBase64($request->get('image-base64'))->toMediaCollection('associate_profile');
            }elseif($request->filled('delete_image') && $request->boolean('delete_image')){ // if the image was replaced above it will automatically delete this so don't run again
                $associate->getFirstMedia('associate_profile')->delete();
            }
            if ($request->hasFile('associate_cc') && $request->file('associate_cc')->isValid()) {
                $associate->addMediaFromRequest('associate_cc')->toMediaCollection('associate_cc');
            }
            if ($request->hasFile('associate_passport') && $request->file('associate_passport')->isValid()) {
                $associate->addMediaFromRequest('associate_passport')->toMediaCollection('associate_passport');
            }
            if ($request->hasFile('associate_curriculum') && $request->file('associate_curriculum')->isValid()) {
                $associate->addMediaFromRequest('associate_curriculum')->toMediaCollection('associate_curriculum');
            }
            if ($request->hasFile('associate_degree_certificate') && $request->file('associate_degree_certificate')->isValid()) {
                $associate->addMediaFromRequest('associate_degree_certificate')->toMediaCollection('associate_degree_certificate');
            }
            if ($request->hasFile('associate_master_certificate') && $request->file('associate_master_certificate')->isValid()) {
                $associate->addMediaFromRequest('associate_master_certificate')->toMediaCollection('associate_master_certificate');
            }
            if ($request->hasFile('associate_degree_final_certificate') && $request->file('associate_degree_final_certificate')->isValid()) {
                $associate->addMediaFromRequest('associate_degree_final_certificate')->toMediaCollection('associate_degree_final_certificate');
            }
            if ($request->hasFile('associate_master_final_certificate') && $request->file('associate_master_final_certificate')->isValid()) {
                $associate->addMediaFromRequest('associate_master_final_certificate')->toMediaCollection('associate_master_final_certificate');
            }
            if ($request->hasFile('associate_degree_inscription_certificate') && $request->file('associate_degree_inscription_certificate')->isValid()) {
                $associate->addMediaFromRequest('associate_degree_inscription_certificate')->toMediaCollection('associate_degree_inscription_certificate');
            }
            if ($request->hasFile('associate_master_inscription_certificate') && $request->file('associate_master_inscription_certificate')->isValid()) {
                $associate->addMediaFromRequest('associate_master_inscription_certificate')->toMediaCollection('associate_master_inscription_certificate');
            }
            if ($request->hasFile('associate_bolonha_degree') && $request->file('associate_bolonha_degree')->isValid()) {
                $associate->addMediaFromRequest('associate_bolonha_degree')->toMediaCollection('associate_bolonha_degree');
            }
            if ($request->hasFile('associate_bolonha_degree_inscription_certificate') && $request->file('associate_bolonha_degree_inscription_certificate')->isValid()) {
                $associate->addMediaFromRequest('associate_bolonha_degree_inscription_certificate')->toMediaCollection('associate_bolonha_degree_inscription_certificate');
            }
            if(!empty($request['company_name'])){
                Company::updateAssociateCompany($associate,$request['company_name'],$request['company_email'],$request['company_address'],$request['company_zip'],$request['company_location'],$request['company_paris'],$request['company_municipality'],$request['company_district'],$request['company_country'],$request['company_vat'],$request['company_status']);
            }
            if(!empty($request['find_ap_name'])){
                FindAp::updateAssociateFindAp($associate,$request['find_ap_name'],$request['find_ap_email'],$request['find_ap_address'],$request['find_ap_phone'],$request['find_ap_status']);
            }
            flash(__('Associate updated successfully.'))->overlay()->success();
            //Flash::success('Associate updated successfully.');
            return redirect(route('associates.edit', $associate));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified Associate from storage.
      *
      * @param  \App\Models\Associate  $associate
      * @return Response
      */
    public function destroy(Associate $associate)
    {
        if(!empty($associate->user)){
            $associate->user->delete();
        }
        $associate->delete();
        //Flash::success('Associate deleted successfully.');

        return redirect(route('associates.index'));
    }

    public function sendApplicationToCAC(Request $request){
        $associate = Associate::findOrFail($request['associate_id']);
        if($associate->status == Associate::STATUS_INCOMPLETE_DATA && $associate->isReadyToSubmit()){
            if($associate->category == Associate::CATEGORY_ASSOCIADO_EFETIVO){
                $associate->status = Associate::STATUS_WAITING_APPROVAL_CAC;
            }else{
                $associate->status = Associate::STATUS_WAITING_BASIC_APPROVAL;
            }
            if($associate->save()){
                return ['success' => true];
            }
        }
        return ['success' => false];
    }

    public function evaluations(Associate $associate){
        $associateEvaluationCac = AssociateEvaluation::where('phase',AssociateEvaluation::PHASE_1)->where('user_id',auth()->user()->id)->where('associate_id',$associate->id)->first();
        $associateEvaluationAdmin = AssociateEvaluation::where('phase',AssociateEvaluation::PHASE_2)->where('user_id',auth()->user()->id)->where('associate_id',$associate->id)->first();
        return view('associates.evaluations', compact('associate','associateEvaluationCac','associateEvaluationAdmin'));
    }

    public function storeEvaluation(Associate $associate,Request $request){
        //dd($request->all());
        if($request['status'] != '' &&  $request['status'] != null){
            $validatedAttributes = AssociateEvaluation::validateForm($request);
            $associateEval = AssociateEvaluation::where('phase',$validatedAttributes['phase'])->where('user_id',$validatedAttributes['user_id'])->where('associate_id',$validatedAttributes['associate_id'])->first();
            if(!empty($associateEval)){
                if($model = $associateEval->update($validatedAttributes)){
                    flash(__('Avaliação registada.'))->overlay()->success();
                }else{
                    flash(__('Ocorreu um erro. Tente mais tarde.'))->overlay()->error();
                }
            }else{
                if($model = AssociateEvaluation::create($validatedAttributes)){
                    \Debugbar::error($associate->is_simple_process == Associate::PROCESS_SIMPLE,$associate->is_process_simple == Associate::PROCESS_COMPLEX,$validatedAttributes['phase'] == 1,AssociateEvaluation::where('phase',1)->where('associate_id',$validatedAttributes['associate_id'])->count() );
                    flash(__('Avaliação registada.'))->overlay()->success();
                    if($associate->is_simple_process == Associate::PROCESS_SIMPLE && $validatedAttributes['phase'] == 1 && AssociateEvaluation::where('phase',1)->where('associate_id',$validatedAttributes['associate_id'])->count() == 2){
                        $associate->status = Associate::STATUS_WAITING_ADMIN_APPROVAL;
                        $associate->evaluation_phase_1_at = Carbon::now();
                    }
                    if($associate->is_simple_process == Associate::PROCESS_COMPLEX && $validatedAttributes['phase'] == 1 && AssociateEvaluation::where('phase',1)->where('associate_id',$validatedAttributes['associate_id'])->count() == 5){
                        $associate->status = Associate::STATUS_WAITING_ADMIN_APPROVAL;
                        $associate->evaluation_phase_1_at = Carbon::now();
                    }
                    if($associate->is_simple_process != Associate::PROCESS_WAITING && $validatedAttributes['phase'] == 2){
                        $associate->evaluation_phase_2_at = Carbon::now();
                        $associate->evaluation_phase_2_user_id = $validatedAttributes['user_id'];
                        $associate->evaluation_note = $request['note'];
                        $associate->evaluation_phase_2_status= $request['status'];
                        $associate->status = Associate::STATUS_WAITING_PAYMENT;
                    }
                    if($validatedAttributes['phase'] == 3){
                        $associate->evaluation_phase_3_at = Carbon::now();
                        $associate->evaluation_phase_3_user_id = $validatedAttributes['user_id'];
                        $associate->evaluation_note_phase_3 = $request['note'];
                        $associate->evaluation_phase_3_status= $request['status'];
                        $associate->status = Associate::STATUS_WAITING_PAYMENT;
                    }
                    $associate->save();
                }else{
                    flash(__('Ocorreu um erro. Tente mais tarde.'))->overlay()->error();
                }
            }
        }else{
            flash(__('Ocorreu um erro. Tente mais tarde.'))->overlay()->error();
        }

        return redirect(route('associates.evaluations', compact('associate')));
    }

    public function endEvaluation(Associate $associate,Request $request){

        if($associate->status == Associate::STATUS_WAITING_APPROVAL_CAC){
            $associate->evaluation_phase_1_at = Carbon::now();
            $associate->evaluation_phase_1_user_id = auth()->user()->id;
            $associate->evaluation_note_phase_1= $request['evaluation_note'];
            $associate->evaluation_phase_1_status= $request['final_status'];
            if(intval($request['final_status']) == AssociateEvaluation::STATUS_ACCEPTED){
                $associate->status = Associate::STATUS_WAITING_ADMIN_APPROVAL;
            }else{
                $associate->status = Associate::STATUS_WAITING_ADMIN_APPROVAL;
            }
        }elseif($associate->status == Associate::STATUS_WAITING_ADMIN_APPROVAL){
            $associate->evaluation_phase_2_at = Carbon::now();
            $associate->evaluation_phase_2_user_id = auth()->user()->id;
            $associate->evaluation_note = $request['evaluation_note'];
            $associate->evaluation_phase_2_status= $request['final_status'];
            if(intval($request['final_status']) == AssociateEvaluation::STATUS_ACCEPTED){
                $associate->status = Associate::STATUS_WAITING_PAYMENT;
            }else{
                $associate->status = Associate::STATUS_REJECTED;
            }
        }
        $associate->save();
        return redirect(route('associates.evaluations', compact('associate')));
    }

    public function contactCandidate(Associate $associate,Request $request){
        if(!empty($request['message']) && !empty($request['subject']) ){
            $associate->notify(new ContactCandidate($request['message'],$request['subject']));
            flash(__('Email enviado com sucesso'))->success()->overlay();
        }else{
            flash(__('Ocorreu uma falha ao enviar o email. Tente novamente.'))->success()->overlay();
        }

        return redirect(route('associates.evaluations', compact('associate')));
    }

    public function getZipDelegation(Request $request){
        if(strlen($request['zip']) == 8 && $request['zip'][4] === "-"){
            $delegation = Associate::getAssociateDelegationByZip($request['zip']);
            return ['success' => true , 'value' => $request['zip'] , 'delegation' => $delegation];
        }
        return ['success' => false , 'value' => $request['zip']];
    }

    public function storeProcess(Associate $associate,Request $request){
        if($request['is_simple_process'] == 1 && AssociateEvaluation::where('phase',1)->where('associate_id',$associate->id)->count() >= 2){
            $associate->is_simple_process = Associate::PROCESS_SIMPLE;
            $associate->status = Associate::STATUS_WAITING_ADMIN_APPROVAL;
            $associate->evaluation_phase_1_at = Carbon::now();
            $associate->save();
        }elseif($request['is_simple_process'] == 2){
            $associate->is_simple_process = Associate::PROCESS_COMPLEX;
            $associate->save();
        }elseif($request['is_simple_process'] == 1){
            $associate->is_simple_process = Associate::PROCESS_SIMPLE;
            $associate->save();
        }

        return redirect(route('associates.evaluations', compact('associate')));
    }

    public function downloadSeguro(){
        return Excel::download(Associate::all(),'teste.pdf');
    }

    public function cropImageUpload(Request $request){
        \Debugbar::error($request->all(),base64_encode($request['image']));
        if (!empty($request['image'])) {
            $associate = Associate::where('id',$request['associate'])->first();
            $associate->addMediaFromBase64($request['image'])->toMediaCollection('associate_profile');
        }
        return ['success' => true];
    }

    public function preferentialContacts(Request $request){
        if(auth()->user()->hasAnyRole('Staff|Direcção|CAC|SuperAdmin') && !empty($request['associate_id'])){
            $associate = Associate::findOrFail($request['associate_id']);
        }elseif(auth()->user()->hasAnyRole('Staff|Direcção|CAC|SuperAdmin') && empty($request['associate_id'])) {
            $associate = null;
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        };
        return view('associates.preferential_contacts', compact('associate'));
    }

    public function updateContact(Associate $associate,Request $request){
        //dd($request->all());
        $associate->preferential_contact = !empty($request['preferential_contact']) && $request['preferential_contact'] === "1" ? 1 : 0;
        if($associate->save()){
            flash()->overlay('Contacto preferencial atualizado com sucesso.')->success();
        }else{
            flash()->overlay('Ocorreu um erro. Tente novamente.')->error();
        }
        $associate_id = $associate->id;
        return redirect(route('associates.preferential_contacts', compact('associate_id')));
    }

    public function updateBillingQuotas(Associate $associate,Request $request){
        $associate->preferential_billing_quotas = !empty($request['preferential_billing_quotas']) ? $request['preferential_billing_quotas'] : Associate::PREFERENTIAL_BILLING_QUOTAS_PERSONAL;
        if($associate->save()){
            flash()->overlay('Faturação preferencial atualizado com sucesso.')->success();
        }else{
            flash()->overlay('Ocorreu um erro. Tente novamente.')->error();
        }
        $associate_id = $associate->id;
        return redirect(route('associates.preferential_contacts', compact('associate_id')));
    }

    public function updateBillingDeclarations(Associate $associate,Request $request){
        $associate->preferential_billing_declarations = !empty($request['preferential_billing_declarations']) ? $request['preferential_billing_declarations'] : Associate::PREFERENTIAL_BILLING_DECLARATIONS_PERSONAL;
        if($associate->save()){
            flash()->overlay('Faturação preferencial atualizado com sucesso.')->success();
        }else{
            flash()->overlay('Ocorreu um erro. Tente novamente.')->error();
        }
        $associate_id = $associate->id;
        return redirect(route('associates.preferential_contacts', compact('associate_id')));
    }

    public function updateUser(User $user,Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [], User::attributeLabels());
        if($request['email'] == $user->email || !User::whereEmail($request['email'])->exists()){
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = Hash::make($request->password);
            if($user->save()){
                flash('Dados de acesso atualizados com sucesso')->overlay()->success();
            }else{
                flash()->overlay('Ocorreu um erro. Tente novamente.')->error();
            }
        }else{
            flash()->overlay('Este email já se encontra em uso.')->error();
        }
        $associate_id = Associate::where('user_id',$user->id)->first()->id;
        return redirect(route('associates.preferential_contacts', compact('associate_id')));

    }

    public function saveProfileImage(Request $request){
        \Debugbar::error($request->all(),base64_encode($request['image']));
        if (!empty($request['image'])) {
            $associate = Associate::where('id',$request['associate'])->first();
            $associate->addMediaFromBase64($request['image'])->toMediaCollection('associate_profile');
        }
        return ['success' => true, 'redirect' => route('associates.edit',[$associate,"associate_id" => $associate->id])];
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, Associate $model = null): array
    {
        $validate_array = Associate::rules();

        if($request->nationality === "PT"){
            $validator = \Illuminate\Support\Facades\Validator::make(['cc_number' => $request->cc_number], ['cc_number' => ['required',new CC()]]);
            if ($validator->fails()) {
                $validator1 = \Illuminate\Support\Facades\Validator::make(['cc_number' => $request->cc_number], ['cc_number' => ['required',new BI()]]);
                if(!$validator1->fails()){
                    $validate_array['cc_number'] = ['required',new BI()];
                }
            }
        }else{
            $validate_array['cc_number'] = ['required'];
        }

        $validator = \Illuminate\Support\Facades\Validator::make(['vat' => $request->vat], ['vat' => ['required',new NIF()]]);
        if($validator->fails()){
            $validate_array['vat'] = ['required',new VatNumber()];
        }else{
            $validate_array['vat'] = ['required',new NIF()];
        }


        /*if(auth()->user()->hasRole('Staff|SuperAdmin')){
            $validate_array['cc_number'] = "required|string";
        }else{
            $validator = \Illuminate\Support\Facades\Validator::make(['cc_number' => $request->cc_number], ['cc_number' => ['required',new CC()]]);
            if ($validator->fails()) {
                $validator1 = \Illuminate\Support\Facades\Validator::make(['cc_number' => $request->cc_number], ['cc_number' => ['required',new BI()]]);
                if(!$validator1->fails()){
                    $validate_array['cc_number'] = ['required',new BI()];
                }
            }
        }*/

        return $request->validate($validate_array, [], Associate::attributeLabels());
    }

    public function reactivateAssociate(Associate $associate){
        $associate->status = Associate::STATUS_ACTIVE;
        $associate->suspended_at = null;
        $associate->save();
        return redirect()->back();
    }

    public function changeStatus(Request $request){
        \Debugbar::error("change",$request->all());
        $associate = Associate::where('id', $request['associate'])->first();
        if(!empty($associate)){
            $associate->status = $request['status'];
            if($associate->save()){
                return['success' => true];
            }
        }
        return['success' => false];
    }
}

<?php

namespace App\Http\Controllers;

use App\DataTables\DeclarationDataTable;
use App\DataTables\DeclarationWaitingApprovalDataTable;
use App\Models\Associate;
use App\Models\DeclarationTemplate;
use App\Models\DeclarationTemplateQuestion;
use App\Notifications\DeclarationActive;
use Carbon\Carbon;
use DvK\Laravel\Vat\Rules\VatNumber;
use Google\Api\Expr\V1beta1\Decl;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateDeclarationRequest;
//use App\Http\Requests\UpdateDeclarationRequest;
use App\Models\Declaration;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use NcJoes\OfficeConverter\OfficeConverter;
use Squarebit\PTRules\Rules\NIF;

class DeclarationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Declaration::class, 'declaration');
    }
    /**
     * Display a listing of the Declaration.
     *
     * @param DeclarationDataTable $declarationDataTable
     * @return Response
     */
    public function index(DeclarationDataTable $declarationDataTable, Request $request)
    {
        if(auth()->user()->can('manageApp') && !empty($request['associate_id'])){
            $associate = Associate::findOrFail($request['associate_id']);
        }elseif(auth()->user()->can('manageApp') && empty($request['associate_id'])) {
            $associate = null;
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        return $declarationDataTable->render('declarations.index',compact('associate'));
    }

    /**
     * Display a listing of the Declaration.
     *
     * @param DeclarationWaitingApprovalDataTable $declarationDataTable
     * @return Response
     */
    public function waitingApproval(DeclarationWaitingApprovalDataTable $declarationDataTable, Request $request)
    {
        return $declarationDataTable->render('declarations.waiting_approval');
    }

    /**
     * Show the form for creating a new Declaration.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $associateOptions = [];
        if(auth()->user()->can('manageApp')){
            $associate = Associate::findOrFail($request['associate_id']);
            $associateOptions[$associate->id] = $associate->name;
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        $declaration = new Declaration();
        $declaration->status = Declaration::STATUS_WAITING_PAYMENT;
        $billingData = $associate->getBillingData(false);
        $declaration->order_name = $billingData['name'];
        $declaration->order_email = $billingData['email'];
        $declaration->order_location = $billingData['location'];
        $declaration->order_phone = $billingData['phone'];
        $declaration->order_vat = $billingData['vat'];
        $declaration->order_address = $billingData['address'];
        $declaration->order_zip = $billingData['zip'];
        $declaration->loadDefaultValues();
        return view('declarations.create', compact('declaration','associate','associateOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->can('accessAsUser') && !empty(DeclarationTemplate::where('id',$request['declaration_template_id'])->first()) && floatval(DeclarationTemplate::where('id',$request['declaration_template_id'])->first()->value) > 0){
            $request->merge(['value' => sprintf("%.2f", DeclarationTemplate::where('id',$request['declaration_template_id'])->first()->value), 'status' => Declaration::STATUS_WAITING_PAYMENT]);
        }elseif(auth()->user()->can('accessAsUser') && !empty(DeclarationTemplate::where('id',$request['declaration_template_id'])->first()) && floatval(DeclarationTemplate::where('id',$request['declaration_template_id'])->first()->value) == 0){
            $request->merge(['value' => sprintf("%.2f", DeclarationTemplate::where('id',$request['declaration_template_id'])->first()->value), 'status' => Declaration::STATUS_WAITING_APPROVAL]);
        }

        $validatedAttributes = $this->validateForm($request);
        //dd($request->all(),$validatedAttributes);
        $questionCodes = DeclarationTemplateQuestion::where('declaration_template_id',$validatedAttributes['declaration_template_id'])->get();
        foreach($questionCodes->pluck('code','id')->toArray() as $code){
            if(!array_key_exists($code,$request->all()) || empty($code)){
                return redirect()->back();
            }
        }
        $questions = [];
        foreach($questionCodes as $code){
            $questions[] = [
                'declaration_template_question_id' => $code->id,
                'question_code' =>  $code->code,
                'question_answer' => $request[$code->code]
            ];
        }

        if(($declaration = Declaration::create($validatedAttributes)) ) {
            if(count($questions)>0){
                $declaration->syncQuestions($questions,$questionCodes);
            }

            if(!empty($declaration->declarationTemplate) && $declaration->declarationTemplate->value > 0 && $declaration->status == Declaration::STATUS_WAITING_PAYMENT){
                $declaration->makeDeclarationOrder($request['order_payment_method'],$request['order_mbway_number'], $request['order_name'],$request['order_email'],$request['order_address'],$request['order_zip'],$request['order_location'],$request['order_phone'],$request['order_vat'],$request['is_renovation']);
            }
            flash(__('Declaration saved successfully.'))->overlay()->success();
            return redirect(route('declarations.show', [$declaration,'associate' => $declaration->associate]));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified Declaration.
     *
     * @param  Declaration  $declaration
     * @return Response
     */
    public function show(Declaration $declaration,Request $request)
    {
        if(auth()->user()->can('manageApp')){
            if(!empty($request['associate_id'])){
                $associate = Associate::findOrFail($request['associate_id']);
            }else{
                $associate = $declaration->associate;
            }

        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        return view('declarations.show', compact('declaration','associate'));
    }

    /**
     * Show the form for editing the specified Declaration.
     *
     * @param  Declaration $declaration
     * @return Response
     */
    public function edit(Declaration $declaration, Request $request)
    {
        $associateOptions = [];
        if(auth()->user()->can('manageApp')){
            $associate = Associate::findOrFail($request['associate_id']);
            $associateOptions[$associate->id] = $associate->name;
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        $declarationtemplateOptions = [];
        if(!empty($declaration->orderItems->first()) && !empty($declaration->orderItems->first()->order)){
            $order = $declaration->orderItems->first()->order;
            $declaration->order_name = $order->name;
            $declaration->order_email = $order->email;
            $declaration->order_location = $order->location;
            $declaration->order_phone = $order->phone;
            $declaration->order_vat = $order->vat;
            $declaration->order_address = $order->address;
            $declaration->order_zip = $order->zip;
            $declaration->order_payment_method = $order->payment_method;
            $declaration->order_mbway_number = $order->mbway_alias;

        }elseif(!empty($declaration->associate)){
            $billingData = $declaration->associate->getBillingData(false);
            $declaration->order_name = $billingData['name'];
            $declaration->order_email = $billingData['email'];
            $declaration->order_location = $billingData['location'];
            $declaration->order_phone = $billingData['phone'];
            $declaration->order_vat = $billingData['vat'];
            $declaration->order_address = $billingData['address'];
            $declaration->order_zip = $billingData['zip'];
        }
        return view('declarations.edit', compact('declaration','associate','associateOptions'));
    }

    /**
     * Update the specified Declaration in storage.
     *
     * @param  Request  $request
     * @param  Declaration $declaration
     * @return Response
     */
    public function update(Request $request, Declaration $declaration)
    {
        $validatedAttributes = $this->validateForm($request, $declaration);
        $declaration->fill($validatedAttributes);
        $questionCodes = DeclarationTemplateQuestion::where('declaration_template_id',$validatedAttributes['declaration_template_id'])->get();

        foreach($questionCodes->pluck('code','id')->toArray() as $code){
            if(!array_key_exists($code,$request->all()) || empty($code)){
                return redirect()->back();
            }
        }
        $questions = [];
        foreach($questionCodes as $key => $code){

            $questions[] = [
                'declaration_template_question_id' => $code->id,
                'question_code' =>  $code->code,
                'question_answer' => $request[$code->code]
            ];
        }
        //dd($questions);
        if($declaration->save()) {
            if(count($questions)>0){
                $declaration->syncQuestions($questions,$questionCodes);
            }
            if(!empty($declaration->orderItems->first()) && !empty($declaration->orderItems->first()->order)){
                $order = $declaration->orderItems->first()->order;
                $order->name = $request['order_name'];
                $order->email = $request['order_email'];
                $order->location = $request['order_location'];
                $order->phone = $request['order_phone'];
                $order->vat = !empty($request['order_vat']) ? str_replace(" ","",$request['order_vat']) : '';
                $order->address = $request['order_address'];
                $order->zip = $request['order_zip'];
                $order->payment_method = $request['order_payment_method'];
                $order->mbway_alias = $request['order_mbway_number'];
                $order->saveQuietly();
            }
            if($request->hasFile('image') && $request->file('image')->isValid()){
                $declaration->addMediaFromRequest('image')->toMediaCollection('declaration_file');
            }elseif($request->filled('delete_image') && $request->boolean('delete_image')){ // if the image was replaced above it will automatically delete this so don't run again
                $declaration->getFirstMedia('declaration_file')->delete();
            }
            flash(__('Declaration updated successfully.'))->overlay()->success();
            //flash('Declaration updated successfully.');
            //Flash::success('Declaration updated successfully.');
            return redirect(route('declarations.show', [$declaration,'associate' => $declaration->associate ]));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified Declaration from storage.
      *
      * @param  \App\Models\Declaration  $declaration
      * @return Response
      */
    public function destroy(Declaration $declaration)
    {
        $declaration->delete();
        flash(__('Declaration deleted successfully.'))->overlay()->success();
        //Flash::success('Declaration deleted successfully.');

        return redirect(route('declarations.index'));
    }

    public function convertWord(Declaration $declaration){
        $declaration->getFinalDocument(true);
        return true;
    }

    public function sendFinalDoc(Declaration $declaration, Request $request){
        if ($request->hasFile('final_document') && $request->file('final_document')->isValid()) {
            \Debugbar::error($request->file('final_document'),$declaration->getFirstMediaUrl('final_document'));
            $declaration->addMediaFromRequest('final_document')->toMediaCollection('final_document');

            if($declaration->status == Declaration::STATUS_WAITING_APPROVAL){
                \Debugbar::error('dentro do if',$declaration->declaration_template_id);
                $declaration->status = Declaration::STATUS_ACTIVE;
                $declaration->declaration_number = $declaration->getNextDeclarationNumber();
                $declaration->save();
                $declaration->refresh();
                $declaration->associate->notify(new DeclarationActive($declaration));
            }elseif($declaration->status == Declaration::STATUS_ACTIVE){
                $declaration->save();
                $declaration->associate->notify(new DeclarationActive($declaration));
                \Debugbar::error($declaration->getFirstMediaUrl('final_document'));
            }

            flash('Documento submetido com sucesso')->overlay()->success();
        }else{
            flash('falha ao submeter o documento')->overlay()->error();
        }
        return redirect(route('declarations.show', [$declaration,'associate_id' => $declaration->associate->id ]));
    }

    public function validateDeclaration(Declaration $declaration,Request $request){
        if(auth()->user()->hasAnyRole('Staff|SuperAdmin')){
            $declaration->status = Declaration::STATUS_ACTIVE;
            $declaration->setDeclarationToActive(true,true);
        }
        //flash()->error('Ocorreu um erro. Por favor tente mais tarde.')->overlay();
        if(!empty($request['associate_id'])){
            return redirect(route('declarations.show',[$declaration,'associate_id' => $request['associate_id']]));
        }else{
            return redirect(route('declarations.show',$declaration));
        }
    }

    public function renovateDeclaration(Declaration $declaration,Request $request){
        $associateOptions = [];
        if(auth()->user()->can('manageApp')){
            $associate = Associate::findOrFail($request['associate_id']);
            $associateOptions[$associate->id] = $associate->name;
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }

        $declaration->valid_until = null;
        $declaration->status = Declaration::STATUS_WAITING_PAYMENT;
        $declaration->order_id = null;
        $declaration->previous_declaration_number = null;
        $declaration->declaration_number = null;
        $billingData = $associate->getBillingData(false);
        $declaration->order_name = $billingData['name'];
        $declaration->order_email = $billingData['email'];
        $declaration->order_location = $billingData['location'];
        $declaration->order_phone = $billingData['phone'];
        $declaration->order_vat = $billingData['vat'];
        $declaration->order_address = $billingData['address'];
        $declaration->order_zip = $billingData['zip'];
        return view('declarations.create',['associate_id'=>$request['associate_id']] ,compact('declaration','associate','associateOptions'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, Declaration $model = null): array
    {

        $validate_array = Declaration::rules();
        $validator = \Illuminate\Support\Facades\Validator::make(['order_vat' => $request->order_vat], ['order_vat' => ['required',new NIF()]]);
        if($validator->fails()){
            $validate_array['order_vat'] = ['required',new VatNumber()];
        }else{
            $validate_array['order_vat'] = ['required',new NIF()];
        }

        return $request->validate($validate_array, [], Declaration::attributeLabels());
    }


}

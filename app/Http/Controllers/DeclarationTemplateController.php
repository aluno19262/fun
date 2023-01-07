<?php

namespace App\Http\Controllers;

use App\DataTables\DeclarationTemplateDataTable;
use App\Models\DeclarationQuestion;
use Google\Api\Expr\V1beta1\Decl;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateDeclarationTemplateRequest;
//use App\Http\Requests\UpdateDeclarationTemplateRequest;
use App\Models\DeclarationTemplate;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;

class DeclarationTemplateController extends Controller
{
    /**
     * Display a listing of the DeclarationTemplate.
     *
     * @param DeclarationTemplateDataTable $declarationTemplateDataTable
     * @return Response
     */
    public function index(DeclarationTemplateDataTable $declarationTemplateDataTable)
    {
        //dd('aqui');
        return $declarationTemplateDataTable->render('declaration_templates.index');
    }

    /**
     * Show the form for creating a new DeclarationTemplate.
     *
     * @return Response
     */
    public function create()
    {
        $declarationTemplate = new DeclarationTemplate();
        $declarationTemplate->loadDefaultValues();
        return view('declaration_templates.create', compact('declarationTemplate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedAttributes = $this->validateForm($request);

        if(($model = DeclarationTemplate::create($validatedAttributes)) ) {
            if($request->hasFile('file') && $request->file('file')->isValid()){
                $model->addMediaFromRequest('file')->toMediaCollection('declaration_template_document');
            }

            flash(__('Declaration Template saved successfully.'))->overlay()->success();
            //Flash::success('Declaration Template saved successfully.');
            return redirect(route('declaration_templates.show', $model));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified DeclarationTemplate.
     *
     * @param  DeclarationTemplate  $declarationTemplate
     * @return Response
     */
    public function show(DeclarationTemplate $declarationTemplate)
    {
        return view('declaration_templates.show', compact('declarationTemplate'));
    }

    /**
     * Show the form for editing the specified DeclarationTemplate.
     *
     * @param  DeclarationTemplate $declarationTemplate
     * @return Response
     */
    public function edit(DeclarationTemplate $declarationTemplate)
    {
        return view('declaration_templates.edit', compact('declarationTemplate'));
    }

    /**
     * Update the specified DeclarationTemplate in storage.
     *
     * @param  Request  $request
     * @param  DeclarationTemplate $declarationTemplate
     * @return Response
     */
    public function update(Request $request, DeclarationTemplate $declarationTemplate)
    {
        //dd($request->all());
        //dd($request->all());
        $validatedAttributes = $this->validateForm($request, $declarationTemplate);
        $declarationTemplate->fill($validatedAttributes);
        if($declarationTemplate->save()) {
            //\Debugbar::error($request['delete_file'],$declarationTemplate->getMedia('declaration_template_document'));
            if(isset($request['DeclarationTemplateQuestions']))
                $declarationTemplate->syncDeclarationTemplateQuestions($request['DeclarationTemplateQuestions'],$request['associate_id']);
            if($request['delete_file']){
                //\Debugbar::error("era true");
                $declarationTemplate->getFirstMedia('declaration_template_document')->delete();
            }
            if($request->hasFile('file') && $request->file('file')->isValid()){
                $declarationTemplate->addMediaFromRequest('file')->toMediaCollection('declaration_template_document');
            }
            //\Debugbar::error($declarationTemplate->getMedia('declaration_template_document'));
            flash(__('Declaration Template updated successfully.'))->overlay()->success();
            //Flash::success('Declaration Template updated successfully.');
            return redirect(route('declaration_templates.show', $declarationTemplate));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified DeclarationTemplate from storage.
      *
      * @param  \App\Models\DeclarationTemplate  $declarationTemplate
      * @return Response
      */
    public function destroy(DeclarationTemplate $declarationTemplate)
    {
        $declarationTemplate->delete();
        //Flash::success('Declaration Template deleted successfully.');

        return redirect(route('declaration_templates.index'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, DeclarationTemplate $model = null): array
    {

        $validate_array = DeclarationTemplate::rules();

        return $request->validate($validate_array, [], DeclarationTemplate::attributeLabels());
    }

    public function getQuestions(Request $request){
        \Debugbar::error($request->all(),$request['declaration_template_id']);
        /*if($request['declaration_id'] !== false){

        }*/
        if(!empty($request['declaration_template_id']) && !empty(DeclarationTemplate::where('id',$request['declaration_template_id'])->first())){

            $arrayToSend = [];
            foreach (DeclarationTemplate::where('id',$request['declaration_template_id'])->first()->declarationTemplateQuestions as $question){
                $arrayToSend[] = [
                    'question' => $question,
                    'value' => !empty(DeclarationQuestion::where('declaration_id',$request['declaration_id'])->where('declaration_template_question_id',$question->id)->first()) ? DeclarationQuestion::where('declaration_id',$request['declaration_id'])->where('declaration_template_question_id',$question->id)->first()->value : ''
                    ];

            }
            return ['success' => true, 'questions' => $arrayToSend];
        }else{
            return ['success' => false];
        }

    }
}

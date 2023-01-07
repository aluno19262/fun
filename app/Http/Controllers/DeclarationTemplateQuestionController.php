<?php

namespace App\Http\Controllers;

use App\DataTables\DeclarationTemplateQuestionDataTable;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateDeclarationTemplateQuestionRequest;
//use App\Http\Requests\UpdateDeclarationTemplateQuestionRequest;
use App\Models\DeclarationTemplateQuestion;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;

class DeclarationTemplateQuestionController extends Controller
{
    /**
     * Display a listing of the DeclarationTemplateQuestion.
     *
     * @param DeclarationTemplateQuestionDataTable $declarationTemplateQuestionDataTable
     * @return Response
     */
    public function index(DeclarationTemplateQuestionDataTable $declarationTemplateQuestionDataTable)
    {
        return $declarationTemplateQuestionDataTable->render('declaration_template_questions.index');
    }

    /**
     * Show the form for creating a new DeclarationTemplateQuestion.
     *
     * @return Response
     */
    public function create()
    {
        $declarationTemplateQuestion = new DeclarationTemplateQuestion();
        $declarationTemplateQuestion->loadDefaultValues();
        return view('declaration_template_questions.create', compact('declarationTemplateQuestion'));
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

        if(($model = DeclarationTemplateQuestion::create($validatedAttributes)) ) {
            flash(__('Declaration Template Question saved successfully.'))->overlay()->success();
            //Flash::success('Declaration Template Question saved successfully.');
            return redirect(route('declaration-template-questions.show', $model));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified DeclarationTemplateQuestion.
     *
     * @param  DeclarationTemplateQuestion  $declarationTemplateQuestion
     * @return Response
     */
    public function show(DeclarationTemplateQuestion $declarationTemplateQuestion)
    {
        return view('declaration_template_questions.show', compact('declarationTemplateQuestion'));
    }

    /**
     * Show the form for editing the specified DeclarationTemplateQuestion.
     *
     * @param  DeclarationTemplateQuestion $declarationTemplateQuestion
     * @return Response
     */
    public function edit(DeclarationTemplateQuestion $declarationTemplateQuestion)
    {
        return view('declaration_template_questions.edit', compact('declarationTemplateQuestion'));
    }

    /**
     * Update the specified DeclarationTemplateQuestion in storage.
     *
     * @param  Request  $request
     * @param  DeclarationTemplateQuestion $declarationTemplateQuestion
     * @return Response
     */
    public function update(Request $request, DeclarationTemplateQuestion $declarationTemplateQuestion)
    {
        $validatedAttributes = $this->validateForm($request, $declarationTemplateQuestion);
        $declarationTemplateQuestion->fill($validatedAttributes);
        if($declarationTemplateQuestion->save()) {
            flash(__('Declaration Template Question updated successfully.'))->overlay()->success();
            //Flash::success('Declaration Template Question updated successfully.');
            return redirect(route('declaration-template-questions.show', $declarationTemplateQuestion));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified DeclarationTemplateQuestion from storage.
      *
      * @param  \App\Models\DeclarationTemplateQuestion  $declarationTemplateQuestion
      * @return Response
      */
    public function destroy(DeclarationTemplateQuestion $declarationTemplateQuestion)
    {
        $declarationTemplateQuestion->delete();
        //Flash::success('Declaration Template Question deleted successfully.');

        return redirect(route('declaration-template-questions.index'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, DeclarationTemplateQuestion $model = null): array
    {

        $validate_array = DeclarationTemplateQuestion::rules();

        return $request->validate($validate_array, [], DeclarationTemplateQuestion::attributeLabels());
    }
}

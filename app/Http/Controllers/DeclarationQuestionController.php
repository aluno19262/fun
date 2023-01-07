<?php

namespace App\Http\Controllers;

use App\DataTables\DeclarationQuestionDataTable;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateDeclarationQuestionRequest;
//use App\Http\Requests\UpdateDeclarationQuestionRequest;
use App\Models\DeclarationQuestion;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;

class DeclarationQuestionController extends Controller
{
    /**
     * Display a listing of the DeclarationQuestion.
     *
     * @param DeclarationQuestionDataTable $declarationQuestionDataTable
     * @return Response
     */
    public function index(DeclarationQuestionDataTable $declarationQuestionDataTable)
    {
        return $declarationQuestionDataTable->render('declaration_questions.index');
    }

    /**
     * Show the form for creating a new DeclarationQuestion.
     *
     * @return Response
     */
    public function create()
    {
        $declarationQuestion = new DeclarationQuestion();
        $declarationQuestion->loadDefaultValues();
        return view('declaration_questions.create', compact('declarationQuestion'));
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

        if(($model = DeclarationQuestion::create($validatedAttributes)) ) {
            flash(__('Declaration Question saved successfully.'))->overlay()->success();
            //Flash::success('Declaration Question saved successfully.');
            return redirect(route('declaration-questions.show', $model));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified DeclarationQuestion.
     *
     * @param  DeclarationQuestion  $declarationQuestion
     * @return Response
     */
    public function show(DeclarationQuestion $declarationQuestion)
    {
        return view('declaration_questions.show', compact('declarationQuestion'));
    }

    /**
     * Show the form for editing the specified DeclarationQuestion.
     *
     * @param  DeclarationQuestion $declarationQuestion
     * @return Response
     */
    public function edit(DeclarationQuestion $declarationQuestion)
    {
        return view('declaration_questions.edit', compact('declarationQuestion'));
    }

    /**
     * Update the specified DeclarationQuestion in storage.
     *
     * @param  Request  $request
     * @param  DeclarationQuestion $declarationQuestion
     * @return Response
     */
    public function update(Request $request, DeclarationQuestion $declarationQuestion)
    {
        $validatedAttributes = $this->validateForm($request, $declarationQuestion);
        $declarationQuestion->fill($validatedAttributes);
        if($declarationQuestion->save()) {
            flash(__('Declaration Question updated successfully.'))->overlay()->success();
            //Flash::success('Declaration Question updated successfully.');
            return redirect(route('declaration-questions.show', $declarationQuestion));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified DeclarationQuestion from storage.
      *
      * @param  \App\Models\DeclarationQuestion  $declarationQuestion
      * @return Response
      */
    public function destroy(DeclarationQuestion $declarationQuestion)
    {
        $declarationQuestion->delete();
        //Flash::success('Declaration Question deleted successfully.');

        return redirect(route('declaration-questions.index'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, DeclarationQuestion $model = null): array
    {

        $validate_array = DeclarationQuestion::rules();

        return $request->validate($validate_array, [], DeclarationQuestion::attributeLabels());
    }
}

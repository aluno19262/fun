<?php

namespace App\Http\Controllers;

use App\DataTables\AssociateEvaluationDataTable;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateAssociateEvaluationRequest;
//use App\Http\Requests\UpdateAssociateEvaluationRequest;
use App\Models\AssociateEvaluation;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;

class AssociateEvaluationController extends Controller
{
    /**
     * Display a listing of the AssociateEvaluation.
     *
     * @param AssociateEvaluationDataTable $associateEvaluationDataTable
     * @return Response
     */
    public function index(AssociateEvaluationDataTable $associateEvaluationDataTable)
    {
        return $associateEvaluationDataTable->render('associate_evaluations.index');
    }

    /**
     * Show the form for creating a new AssociateEvaluation.
     *
     * @return Response
     */
    public function create()
    {
        $associateEvaluation = new AssociateEvaluation();
        $associateEvaluation->loadDefaultValues();
        return view('associate_evaluations.create', compact('associateEvaluation'));
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

        if(($model = AssociateEvaluation::create($validatedAttributes)) ) {
            flash(__('Associate Evaluation saved successfully.'))->overlay()->success();
            //Flash::success('Associate Evaluation saved successfully.');
            return redirect(route('associate-evaluations.show', $model));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified AssociateEvaluation.
     *
     * @param  AssociateEvaluation  $associateEvaluation
     * @return Response
     */
    public function show(AssociateEvaluation $associateEvaluation)
    {
        return view('associate_evaluations.show', compact('associateEvaluation'));
    }

    /**
     * Show the form for editing the specified AssociateEvaluation.
     *
     * @param  AssociateEvaluation $associateEvaluation
     * @return Response
     */
    public function edit(AssociateEvaluation $associateEvaluation)
    {
        return view('associate_evaluations.edit', compact('associateEvaluation'));
    }

    /**
     * Update the specified AssociateEvaluation in storage.
     *
     * @param  Request  $request
     * @param  AssociateEvaluation $associateEvaluation
     * @return Response
     */
    public function update(Request $request, AssociateEvaluation $associateEvaluation)
    {
        $validatedAttributes = $this->validateForm($request, $associateEvaluation);
        $associateEvaluation->fill($validatedAttributes);
        if($associateEvaluation->save()) {
            flash(__('Associate Evaluation updated successfully.'))->overlay()->success();
            //Flash::success('Associate Evaluation updated successfully.');
            return redirect(route('associate-evaluations.show', $associateEvaluation));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified AssociateEvaluation from storage.
      *
      * @param  \App\Models\AssociateEvaluation  $associateEvaluation
      * @return Response
      */
    public function destroy(AssociateEvaluation $associateEvaluation)
    {
        $associateEvaluation->delete();
        //Flash::success('Associate Evaluation deleted successfully.');

        return redirect(route('associate-evaluations.index'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, AssociateEvaluation $model = null): array
    {

        $validate_array = AssociateEvaluation::rules();

        return $request->validate($validate_array, [], AssociateEvaluation::attributeLabels());
    }
}

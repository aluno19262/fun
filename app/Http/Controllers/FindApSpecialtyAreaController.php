<?php

namespace App\Http\Controllers;

use App\DataTables\FindApSpecialtyAreaDataTable;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateFindApSpecialtyAreaRequest;
//use App\Http\Requests\UpdateFindApSpecialtyAreaRequest;
use App\Models\FindApSpecialtyArea;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;

class FindApSpecialtyAreaController extends Controller
{
    /**
     * Display a listing of the FindApSpecialtyArea.
     *
     * @param FindApSpecialtyAreaDataTable $findApSpecialtyAreaDataTable
     * @return Response
     */
    public function index(FindApSpecialtyAreaDataTable $findApSpecialtyAreaDataTable)
    {
        return $findApSpecialtyAreaDataTable->render('find_ap_specialty_areas.index');
    }

    /**
     * Show the form for creating a new FindApSpecialtyArea.
     *
     * @return Response
     */
    public function create()
    {
        $findApSpecialtyArea = new FindApSpecialtyArea();
        $findApSpecialtyArea->loadDefaultValues();
        return view('find_ap_specialty_areas.create', compact('findApSpecialtyArea'));
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

        if(($model = FindApSpecialtyArea::create($validatedAttributes)) ) {
            //flash(Find Ap Specialty Area saved successfully.');
            //Flash::success('Find Ap Specialty Area saved successfully.');
            return redirect(route('find-ap-specialty-areas.show', $model));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified FindApSpecialtyArea.
     *
     * @param  FindApSpecialtyArea  $findApSpecialtyArea
     * @return Response
     */
    public function show(FindApSpecialtyArea $findApSpecialtyArea)
    {
        return view('find_ap_specialty_areas.show', compact('findApSpecialtyArea'));
    }

    /**
     * Show the form for editing the specified FindApSpecialtyArea.
     *
     * @param  FindApSpecialtyArea $findApSpecialtyArea
     * @return Response
     */
    public function edit(FindApSpecialtyArea $findApSpecialtyArea)
    {
        return view('find_ap_specialty_areas.edit', compact('findApSpecialtyArea'));
    }

    /**
     * Update the specified FindApSpecialtyArea in storage.
     *
     * @param  Request  $request
     * @param  FindApSpecialtyArea $findApSpecialtyArea
     * @return Response
     */
    public function update(Request $request, FindApSpecialtyArea $findApSpecialtyArea)
    {
        $validatedAttributes = $this->validateForm($request, $findApSpecialtyArea);
        $findApSpecialtyArea->fill($validatedAttributes);
        if($findApSpecialtyArea->save()) {
            //flash('Find Ap Specialty Area updated successfully.');
            //Flash::success('Find Ap Specialty Area updated successfully.');
            return redirect(route('find-ap-specialty-areas.show', $findApSpecialtyArea));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified FindApSpecialtyArea from storage.
      *
      * @param  \App\Models\FindApSpecialtyArea  $findApSpecialtyArea
      * @return Response
      */
    public function destroy(FindApSpecialtyArea $findApSpecialtyArea)
    {
        $findApSpecialtyArea->delete();
        //Flash::success('Find Ap Specialty Area deleted successfully.');

        return redirect(route('find-ap-specialty-areas.index'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, FindApSpecialtyArea $model = null): array
    {

        $validate_array = FindApSpecialtyArea::rules();

        return $request->validate($validate_array, [], FindApSpecialtyArea::attributeLabels());
    }
}

<?php

namespace App\Http\Controllers;

use App\DataTables\FindApDataTable;
use App\Models\Associate;
use App\Models\MapWp;
use App\Models\Policies\FindApPolicy;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateFindApRequest;
//use App\Http\Requests\UpdateFindApRequest;
use App\Models\FindAp;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;

class FindApController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FindAp::class);
    }
    /**
     * Display a listing of the FindAp.
     *
     * @param FindApDataTable $findApDataTable
     * @return Response
     */
    public function index(FindApDataTable $findApDataTable)
    {
        return $findApDataTable->render('find_aps.index');
    }

    /**
     * Show the form for creating a new FindAp.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if(auth()->user()->can('manageApp') || auth()->user()->can('accessAsCAC')){
            $associate = Associate::findOrFail($request['associate_id']);
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        $findAp = new FindAp();
        $findAp->loadDefaultValues();
        return view('find_aps.create', compact('findAp','associate'));
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

        if(($model = FindAp::create($validatedAttributes)) ) {
            if(isset($validatedAttributes['specialtyAreas'])){
                FindAp::syncFindApSpecialtyAreas($model,$validatedAttributes['specialtyAreas']);
            }
            if(!empty($request['associate_id'])){
                $associate = Associate::findOrFail($request['associate_id']);
                $associate->find_ap_id = $model->id;
                $associate->saveQuietly();
                $model->updateWpMapsLocations();
                //MapWp::updateMapLocations();
            }
            flash(__('Find Ap saved successfully.'))->overlay()->success();
            //Flash::success('Find Ap saved successfully.');
            return redirect(route('find-aps.edit', [$model,"associate_id" => Associate::findOrFail($request['associate_id'])->id ]));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified FindAp.
     *
     * @param  FindAp  $findAp
     * @return Response
     */
    public function show(FindAp $findAp)
    {
        return view('find_aps.show', compact('findAp'));
    }

    /**
     * Show the form for editing the specified FindAp.
     *
     * @param  FindAp $findAp
     * @return Response
     */
    public function edit(FindAp $findAp,Request $request)
    {
        if(auth()->user()->can('manageApp') || auth()->user()->can('accessAsCAC')){
            $associate = Associate::findOrFail($request['associate_id']);
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        $findAp->specialtyAreas = $findAp->findApSpecialtyAreas()->pluck('specialty_area')->toArray();
        return view('find_aps.edit', compact('findAp','associate'));
    }

    /**
     * Update the specified FindAp in storage.
     *
     * @param  Request  $request
     * @param  FindAp $findAp
     * @return Response
     */
    public function update(Request $request, FindAp $findAp)
    {
        if(empty($request['status'])){
            $request->merge(['status' => 0]);
        }else{
            $request->merge(['status' => 1]);
        }
        $validatedAttributes = $this->validateForm($request, $findAp);
        $findAp->fill($validatedAttributes);
        if($findAp->save()) {
            if(isset($validatedAttributes['specialtyAreas'])){
                FindAp::syncFindApSpecialtyAreas($findAp,$validatedAttributes['specialtyAreas']);
            }
            $findAp->updateWpMapsLocations();
            flash(__('Find Ap updated successfully.'))->overlay()->success();
            return redirect(route('find-aps.edit', [$findAp,'associate_id' => $request['associate_id']]));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified FindAp from storage.
      *
      * @param  \App\Models\FindAp  $findAp
      * @return Response
      */
    public function destroy(FindAp $findAp)
    {
        $findAp->delete();
        //Flash::success('Find Ap deleted successfully.');

        return redirect(route('find-aps.index'));
    }

    public function publicFindAp(Request $request){
        $findAps = FindAp::whereNotNull('address')->count();
        return view('find_aps.public',compact('findAps'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, FindAp $model = null): array
    {

        $validate_array = FindAp::rules();

        return $request->validate($validate_array, [], FindAp::attributeLabels());
    }
}

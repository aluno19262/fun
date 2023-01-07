<?php

namespace App\Http\Controllers;

use App\DataTables\DemoDataTable;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateDemoRequest;
//use App\Http\Requests\UpdateDemoRequest;
use App\Models\Demo;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;

class DemoController extends Controller
{
    /**
     * Display a listing of the Demo.
     *
     * @param DemoDataTable $demoDataTable
     * @return Response
     */
    public function index(DemoDataTable $demoDataTable)
    {
        return $demoDataTable->render('demos.index');
    }

    /**
     * Show the form for creating a new Demo.
     *
     * @return Response
     */
    public function create()
    {
        $demo = new Demo();
        $demo->loadDefaultValues();
        return view('demos.create', compact('demo'));
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

        if(($model = Demo::create($validatedAttributes)) ) {
            //flash(Demo saved successfully.');
            //Flash::success('Demo saved successfully.');
            return redirect(route('demos.show', $model));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified Demo.
     *
     * @param  Demo  $demo
     * @return Response
     */
    public function show(Demo $demo)
    {
        return view('demos.show', compact('demo'));
    }

    /**
     * Show the form for editing the specified Demo.
     *
     * @param  Demo $demo
     * @return Response
     */
    public function edit(Demo $demo)
    {
        return view('demos.edit', compact('demo'));
    }

    /**
     * Update the specified Demo in storage.
     *
     * @param  Request  $request
     * @param  Demo $demo
     * @return Response
     */
    public function update(Request $request, Demo $demo)
    {
        $validatedAttributes = $this->validateForm($request, $demo);
        $demo->fill($validatedAttributes);
        if($demo->save()) {
            //flash('Demo updated successfully.');
            //Flash::success('Demo updated successfully.');
            return redirect(route('demos.show', $demo));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified Demo from storage.
      *
      * @param  \App\Models\Demo  $demo
      * @return Response
      */
    public function destroy(Demo $demo)
    {
        $demo->delete();
        //Flash::success('Demo deleted successfully.');

        return redirect(route('demos.index'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, Demo $model = null): array
    {

        $validate_array = Demo::rules();

        return $request->validate($validate_array, [], Demo::attributeLabels());
    }
}

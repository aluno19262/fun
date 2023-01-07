<?php

namespace App\Http\Controllers;

use App\DataTables\CompanyDataTable;
use App\Models\Associate;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateCompanyRequest;
//use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }
    /**
     * Display a listing of the Company.
     *
     * @param CompanyDataTable $companyDataTable
     * @return Response
     */
    public function index(CompanyDataTable $companyDataTable)
    {
        return $companyDataTable->render('companies.index');
    }

    /**
     * Show the form for creating a new Company.
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
        $company = new Company();
        $company->loadDefaultValues();
        $company->preferential_contact = $associate->preferential_contact;
        return view('companies.create', compact('company','associate'));
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
        if(($model = Company::create($validatedAttributes)) ) {
            if(!empty($request['associate_id'])){
                $associate = Associate::findOrFail($request['associate_id']);
                $associate->company_id = $model->id;
                $associate->preferential_contact = $request['preferential_contact'];
                $associate->saveQuietly();
            }
            flash(__('Company saved successfully.'))->overlay()->success();
            //Flash::success('Company saved successfully.');
            return redirect(route('companies.edit', [$model,"associate_id" => Associate::findOrFail($request['associate_id'])->id ]));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified Company.
     *
     * @param  Company  $company
     * @return Response
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified Company.
     *
     * @param  Company $company
     * @return Response
     */
    public function edit(Company $company,Request $request)
    {
        if((auth()->user()->can('manageApp') || auth()->user()->can('accessAsCAC')) && $company->associate){
            $associate = Associate::findOrFail($request['associate_id']);
        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        $company->preferential_contact = $associate->preferential_contact;
        return view('companies.edit', compact('company','associate'));
    }

    /**
     * Update the specified Company in storage.
     *
     * @param  Request  $request
     * @param  Company $company
     * @return Response
     */
    public function update(Request $request, Company $company)
    {
        $validatedAttributes = $this->validateForm($request, $company);
        $company->fill($validatedAttributes);
        if($company->save()) {
            if(!empty($company->associate) && !empty($request['preferential_contact'])){
                $company->associate->preferential_contact = $request['preferential_contact'];
                $company->associate->saveQuietly();
            }
            flash('Informação da Empresa guardada com sucesso.')->overlay();
            return redirect(route('companies.edit', $company));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified Company from storage.
      *
      * @param  \App\Models\Company  $company
      * @return Response
      */
    public function destroy(Company $company, Request $request)
    {
        $associate = $company->associate;
        if($company->delete()){
            if($request->ajax()){
                return ['success' => true, 'redirect' => ''.route('companies.create',['associate_id' => $associate->id])];
            }else{
                return redirect(route('companies.create',['associate_id' => $associate->id]));
            }
        }else{
            if($request->ajax()){
                return ['success' => false, 'redirect' => ''.route('companies.edit', $associate)];
            }else{
                return redirect(route('companies.edit',$associate));
            }
        }

        //Flash::success('Company deleted successfully.');



    }

    /**
     * @return array
     */
    public function validateForm(Request $request, Company $model = null): array
    {

        $validate_array = Company::rules();

        return $request->validate($validate_array, [], Company::attributeLabels());
    }
}

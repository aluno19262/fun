<?php

namespace App\Http\Controllers;

use App\DataTables\QuotaDataTable;
use App\Models\Associate;
use App\Models\Order;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateQuotaRequest;
//use App\Http\Requests\UpdateQuotaRequest;
use App\Models\Quota;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;

class QuotaController extends Controller
{
    /**
     * Display a listing of the Quota.
     *
     * @param QuotaDataTable $quotaDataTable
     * @return Response
     */
    public function index(QuotaDataTable $quotaDataTable,Request $request)
    {
        if(auth()->user()->can('manageApp') || auth()->user()->can('accessAsCAC')){
            $associate = Associate::findOrFail($request['associate_id']);

        }elseif(($associate = auth()->user()->associate) == null){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        return $quotaDataTable->render('quotas.index',compact('associate'));
    }

    /**
     * Show the form for creating a new Quota.
     *
     * @return Response
     */
    public function create()
    {
        $quota = new Quota();
        $quota->loadDefaultValues();
        return view('quotas.create', compact('quota'));
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

        if(($model = Quota::create($validatedAttributes)) ) {
            flash(__('Quota saved successfully.'))->overlay()->success();
            //Flash::success('Quota saved successfully.');
            return redirect(route('quotas.show', $model));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified Quota.
     *
     * @param  Quota  $quota
     * @return Response
     */
    public function show(Quota $quota)
    {
        return view('quotas.show', compact('quota'));
    }

    /**
     * Show the form for editing the specified Quota.
     *
     * @param  Quota $quota
     * @return Response
     */
    public function edit(Quota $quota)
    {
        return view('quotas.edit', compact('quota'));
    }

    /**
     * Update the specified Quota in storage.
     *
     * @param  Request  $request
     * @param  Quota $quota
     * @return Response
     */
    public function update(Request $request, Quota $quota)
    {
        $validatedAttributes = $this->validateForm($request, $quota);
        $quota->fill($validatedAttributes);
        if($quota->save()) {
            flash(__('Quota updated successfully.'))->overlay()->success();
            //Flash::success('Quota updated successfully.');
            return redirect(route('quotas.show', $quota));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified Quota from storage.
      *
      * @param  \App\Models\Quota  $quota
      * @return Response
      */
    public function destroy(Quota $quota)
    {
        $quota->delete();
        //Flash::success('Quota deleted successfully.');

        return redirect(route('quotas.index'));
    }

    public function payQuotas(Request $request){
        $order = Order::where('id',$request['order_id'])->first();
        if(!empty($order)){
            if($request['semester'] == "1"){
                $order->updateToHalfPayedOrder();
            }
            $order->status = Order::STATUS_PAYED;
            $order->payment_method = Order::PAYMENT_METHOD_UNSELECTED;
            $order->save();
            \Debugbar::error('chegou aqui', $request->all());
            return ['success' => true, 'request' => $request->all()];
        }
        return ['success' => false];
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, Quota $model = null): array
    {

        $validate_array = Quota::rules();

        return $request->validate($validate_array, [], Quota::attributeLabels());
    }
}

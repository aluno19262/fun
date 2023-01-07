<?php

namespace App\DataTables;

use App\Models\Associate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;
use App\DataTables\Traits\DatatableColumnSearch;

class AssociateDataTable extends DataTable
{
    use DatatableColumnSearch;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', '{!! date(\'d-m-Y H:i:s\', strtotime($created_at)) !!}')
            ->editColumn('quota_valid_until', function ($associate) {
                return !empty($associate->quota_valid_until) ? $associate->quota_valid_until->format('d-m-Y') : '';
            })
            ->editColumn('status', function($associate){
                if(auth()->user()->hasAnyRole('SuperAdmin|Staff')){
                    $options = '';
                    \Debugbar::error($associate->getStatusOptions());
                    foreach($associate->getStatusOptions() as $key => $associateStatus){
                        $selected = $associateStatus === $associate->getStatusLabelAttribute() ? 'selected' : '';
                        $options = $options . '<option value='.$key . ' '. $selected .' >'. $associateStatus .'</option>';
                    }
                    return '<select class="form-control form-control-solid " onchange="onChangeAssociateStatus(this,'.$associate->id.')">'. $options .'</select>';
                }else{
                    return $associate->getStatusLabelAttribute();
                }
            })
            /*->editColumn('status', function ($associate) {

                if($associate->status == Associate::STATUS_SUSPENDED && auth()->user()->hasAnyRole('SuperAdmin|Staff')){
                    return '<a href="'.route('associate.reactivate_associate',$associate).'">Reactivar</a>';
                }
                return $associate->getStatusLabelAttribute();
            })*/
            ->editColumn('registration_date', function ($associate) {
                return !empty($associate->registration_date) ? $associate->registration_date->format('d-m-Y') : "";
            })
            ->editColumn('category', function ($associate) {
                return $associate->getCategoryLabelAttribute();
            })
            ->editColumn('associate_number', function ($associate) {
                return $associate->associate_number;
            })
            ->editColumn('address', function ($associate) {
                $address = "";
                if(!empty($associate->address) && $associate->address != ""){
                    if($address === ""){
                        $address = $address . $associate->address;
                    }else{
                        $address = $address . " - " . $associate->address;
                    }
                }

                return $address;
            })
            ->addColumn('address_2', function ($associate) {
                $address = "";
                if(!empty($associate->zip) && $associate->zip != ""){
                    if($address == ""){
                        $address = $address . $associate->zip;
                    }else{
                        $address = $address . " - " . $associate->zip;
                    }
                }
                if(!empty($associate->location) && $associate->location != ""){
                    if($address == ""){
                        $address = $address . $associate->location;
                    }else{
                        $address = $address . " " . $associate->location;
                    }
                }

                return $address;
            })
            ->addColumn('address_3', function ($associate) {
                $address = "";
                if(!empty($associate->country) && $associate->country != ""){
                    if($address == ""){
                        $address = $address . $associate->country;
                    }else{
                        $address = $address . " - " . $associate->country;
                    }
                }
                return $address;
            })
            ->addColumn('address_4', function ($associate) {
                return "$associate->name <br>$associate->address <br>$associate->zip  $associate->location";
            })
            ->addColumn('action', function ($associate) {
                if(auth()->user()->hasAnyRole('SuperAdmin|Staff')){
                    return '<a class="btn btn-sm btn-bg-light btn-color-primary btn-icon mx-2" href="'. route('associates.edit', $associate) .'" title="'. __('View') .'">'. theme()->getSvgIcon("icons/duotune/general/gen004.svg", "svg-icon-2") .'</a><button class="btn btn-sm btn-bg-light btn-color-primary btn-icon delete-confirmation" data-destroy-form-id="destroy-form-'. $associate->id .'" data-delete-url="'. route('associates.destroy', $associate) .'" onclick="destroyConfirmation(this)" title="'. __('Delete') .'">'. theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-2") .'</button>';
                }
                return '<a class="btn btn-sm btn-bg-light btn-color-primary btn-icon" href="'. route('associates.edit', $associate) .'" title="'. __('View') .'">'. theme()->getSvgIcon("icons/duotune/general/gen004.svg", "svg-icon-2") .'</a>';
            })
            ->setRowClass('text-gray-600 fw-bold')->rawColumns(['action','status']);
            //->editColumn('type', '{{ $this->typeLabel }}')
            /*->editColumn('type', function ($model) {
                              return  $model->typeLabel;
                          })*/
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Associate $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Associate $model,\Illuminate\Http\Request $request)
    {
        /*if(auth()->user()->can('adminFullApp') && !empty($request->ctt) && $request->ctt == 1){
            return
        }*/
        if(!empty($request->export)){
            if($request->export == 1){
                return $model->newQuery()->where('status',Associate::STATUS_ACTIVE);
            }
            if($request->export == 2){
                return $model->newQuery()->where('status',Associate::STATUS_ACTIVE)->where(function($q) {
                    $q->whereDate('quota_valid_until','<',Carbon::today())
                        ->orWhereNull('quota_valid_until');
                });
            }
            if($request->export == 3 || $request->export == 4){
                return $model->newQuery()->where('status',Associate::STATUS_ACTIVE)->whereDate('quota_valid_until','>=',Carbon::today());
            }
        }
        if(request()->get('show-all') == 1 && !empty(auth()->user()) && auth()->user()->hasAnyRole('SuperAdmin|Staff')){
            return $model->newQuery();
        }
        if(auth()->user()->can('accessAsCAC') && !auth()->user()->hasAnyRole('SuperAdmin|Staff')){
            debugbar()->error("caiu aqui");
            return $model->newQuery()->whereNotIn('status',[Associate::STATUS_WAITING_APPROVAL_CAC,Associate::STATUS_WAITING_ADMIN_APPROVAL,Associate::STATUS_INCOMPLETE_DATA,Associate::STATUS_WAITING_PAYMENT])->where('category',Associate::CATEGORY_ASSOCIADO_EFETIVO);
        }elseif(!auth()->user()->hasAnyRole('SuperAdmin|Staff')){
            return $model->newQuery()->whereNotIn('status',[Associate::STATUS_WAITING_APPROVAL_CAC,Associate::STATUS_WAITING_ADMIN_APPROVAL,Associate::STATUS_WAITING_BASIC_APPROVAL,Associate::STATUS_INCOMPLETE_DATA,Associate::STATUS_WAITING_PAYMENT]);
        }

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('associates-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("tr<'row'<'col-sm-12 col-md-5 d-flex text-dark align-items-center justify-content-center justify-content-md-start'li><'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>")
            ->stateSave(false)
            ->responsive()
            ->autoWidth(false)
            ->initComplete($this->searchJS)
            /*->orderBy([1,  DB::raw('lpad(associate_number, 10, 0) desc')])*/
            ->orderBy([0, 'asc'])
            ->parameters([
                'buttons' => ['export'],
                'language' => [
                    'url' => asset('lang/pt/datatable-full.json'),
                    'buttons'=> [
                        'export' => 'Exportar',
                        'print' => 'Imprimir',
                    ]
                ]
            ])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5 text-dark');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $model = new Associate();
        if(!empty(request()->ctt) && request()->ctt == 1){
            return [
                Column::make('address_4')->title(__('Morada'))->exportable(true)
            ];
        }
        return [
            Column::make('id')->title($model->getAttributeLabel('id'))->exportable(false)->hidden(),
            Column::make('associate_number')->title($model->getAttributeLabel('associate_number'))->exportable(true),
            Column::make('name')->title($model->getAttributeLabel('name'))->exportable(true)->attributes(['data-regex' => 'false']),
            Column::make('category')->title($model->getAttributeLabel('category'))->exportable(true)->attributes(['data-options' => json_encode(Associate::getCategoryArray())]),
            Column::make('address')->title($model->getAttributeLabel('address'))->exportable(true)->hidden(),
            Column::make('address_2')->title(__('Localidade'))->exportable(true)->hidden(),
            Column::make('address_3')->title(__('País'))->exportable(true)->hidden(),
            Column::make('quota_valid_until')->title($model->getAttributeLabel('quota_valid_until'))->exportable(true),
            Column::make('registration_date')->title($model->getAttributeLabel('registration_date'))->visible(false)->exportable(true),
            Column::make('vat')->title($model->getAttributeLabel('vat'))->visible(false)->exportable(true),
            Column::make('cc_number')->title($model->getAttributeLabel('cc_number'))->visible(false)->exportable(true),
            Column::make('status')->title($model->getAttributeLabel('status'))->exportable(false)->attributes(['data-options' => json_encode(Associate::getStatusToShowUsersArray())]),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->responsivePriority(-1)
                ->addClass('text-center')
                ->title(__('Action')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'associates_' . date('YmdHis');
    }
}

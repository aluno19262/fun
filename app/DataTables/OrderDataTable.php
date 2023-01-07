<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;
use App\DataTables\Traits\DatatableColumnSearch;

class OrderDataTable extends DataTable
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
            ->editColumn('name', function ($order){
                if(auth()->user()->can('manageApp') && !empty($order->associate)){
                    return '<a href="'.route('associates.edit',[$order->associate->id]).'">'.$order->name.'</a>';
                }else{
                    return $order->name;
                }

            })
            ->addColumn('associate', function ($order) {
                return !empty($order->associate) ? $order->associate->name . " [" .$order->associate->associate_number ."]" : "";
            })

            ->editColumn('created_at', function ($order){
                return $order->created_at->format('d-m-Y h:i');
            })

            ->editColumn('payment_method', function ($order){
                return $order->getPaymentMethodLabelAttribute();
            })
            ->addColumn('payment_name', function ($order){
                $orderItems = $order->orderItems;
                $paymentName = "";
                foreach ($orderItems as $item){
                    $paymentName = $paymentName ."<span>" . $item->name ."</span><br>";
                }
                return $paymentName;
            })

            ->editColumn('status', function ($order){
                return $order->getStatusLabelAttribute();
            })


            ->editColumn('total', function ($order){
                if(!empty($order->total)){
                    return $order->total . ' €';
                }else{
                    return '---';
                }

            })
            ->editColumn('invoice_status', function ($model) {
                if($model->invoice_status == Order::INVOICE_STATUS_WAITING_EMISSION && auth()->user()->hasAnyRole('SuperAdmin|Staff')){
                    if($model->status == Order::STATUS_PAYED){
                        return "<a href='".route('orders.generate_invoice_datatable',$model)."'>Gerar</a>";
                    }else{
                        return  $model->getInvoiceStatusLabelAttribute();
                    }
                }elseif($model->invoice_status ==Order::INVOICE_STATUS_FINAL && $model->status == Order::STATUS_PAYED) {
                    return "<a href='".route('orders.show',$model)."'>$model->invoice_number</a>";
                }else{
                    $html =  "";
                    //$html =  $model->getInvoiceStatusLabelAttribute();
                    if(!empty($model->invoice_link)){
                        $html.='<br><a href="'.$model->invoice_link.'" target="_blank">'.__('Download').'</a>';
                    }
                    return $html;
                }
            })
            ->addColumn('action', function ($order) {
                if(auth()->user()->can('accessAsUser')){
                    if(!empty($model->invoice_link)){
                        return '<a class="btn btn-sm btn-light mx-2" href="'. route('orders.show', $order) .'">'.__('Dados de pagamento').'</a>';
                    }else{
                        return '<a class="btn btn-sm btn-light mx-2" href="'. route('orders.show', $order) .'">'.__('Dados de pagamento').'</a>';
                    }
                }else {
                    if (!empty($order->associate)) {
                        return '<a class="btn btn-sm btn-bg-light btn-color-primary btn-icon" href="' . route('orders.show', [$order, 'associate_id' => $order->associate->id]) . '" title="' . __('View') . '">' . theme()->getSvgIcon("icons/duotune/general/gen004.svg", "svg-icon-2") . '</a>
                        <a class="btn btn-sm btn-bg-light btn-color-primary btn-icon" href="' . route('orders.edit', [$order, 'associate_id' => $order->associate->id]) . '" title="' . __('Edit') . '">' . theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-2") . '</a>';
                    }
                }
            })
            ->setRowClass('text-gray-600 fw-bold')->rawColumns(['action','name','invoice_status','payment_name']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model,\Illuminate\Http\Request $request)
    {
        $query = $model->newQuery()->where('status', '!=', Order::STATUS_REMOVED);
        if(request()->get('payment-method') == Order::PAYMENT_METHOD_WIRE_TRANSFER && auth()->user()->hasRole('Staff|SuperAdmin')){
            $query->where('payment_method',request()->get('payment-method'));
        }

        if((!empty($request['associate_id']) && !empty(auth()->user()->associate) && auth()->user()->associate->id == $request['associate_id']) || (empty($request['associate_id']) && !empty(auth()->user()->associate)) ){
            $associate = !empty($request['associate_id']) ? $request['associate_id'] : auth()->user()->associate->id;
            $query->where('associate_id',$associate);
        }elseif(auth()->user()->hasRole('Staff|SuperAdmin') && !empty($request['associate_id'])){
            $query->where('associate_id',$request['associate_id']);
            //return $model->newQuery()->where('associate_id',$request['associate_id'])->where('status', '!=', Order::STATUS_REMOVED);
        }elseif(auth()->user()->hasRole('Staff|SuperAdmin') && empty($request['associate_id'])){
            //return $model->newQuery()->where('status', '!=', Order::STATUS_REMOVED);
        }else{
            $query->whereNull('id');
        }


        return $query;


    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("tr<'row'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'li><'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>")
            ->stateSave(false)
            ->responsive()
            ->autoWidth(false)
            ->initComplete($this->searchJS)
            ->orderBy([0, 'desc'])
            ->parameters([
                'buttons' => [],
                'language' => [
                    'url' => asset('lang/pt/datatable-full.json'),
                    'buttons'=> [
                        'export' => 'Exportar',
                        'print' => 'Imprimir',
                    ]
                ]
            ])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $model = new Order();
        return [
            Column::make('id')->title(__('ID'))->visible(false),
            Column::make('invoice_status')->title(__('Fatura'))->attributes(['data-options' => json_encode(Order::getInvoiceStatusArray())]),
            Column::make('associate')->title(__('Associate'))->visible(auth()->user()->can('manageApp')),
            Column::make('payment_name')->title(__('Movimento')),
            Column::make('vat')->title($model->getAttributeLabel('vat')),
            Column::make('total')->title(__('Valor')),
            Column::make('created_at')->title(__('Data')),
            Column::make('status')->title(__('Estado'))->attributes(['data-options' => json_encode(Order::getStatusArray())]),


            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                //->width(120)
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
        return 'orders_' . date('YmdHis');
    }
}

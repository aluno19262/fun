<?php

namespace App\DataTables;

use App\Models\Associate;
use App\Models\Quota;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;
use App\DataTables\Traits\DatatableColumnSearch;

class QuotaDataTable extends DataTable
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
            ->editColumn('status', function ($quota){
                if($quota->status == Quota::STATUS_INACTIVE){
                    return "A Aguardar Pagamento";
                }elseif($quota->status == Quota::STATUS_ACTIVE){
                    return "Pago";
                }else{
                    return "";
                }
            })
            ->editColumn('price', function ($quota){
                return !empty($quota->price) ? $quota->price .'€' : '';
            })
            ->editColumn('semester', function ($quota){
                if($quota->semester == 0){
                    return "Anual";
                }elseif($quota->semester == 1){
                    return "1º Semestre";
                }elseif($quota->semester == 2){
                    return "2º Semestre";
                }else{
                    return "";
                }
            })
            ->setRowClass('text-gray-600 fw-bold');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Quota $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Quota $model,\Illuminate\Http\Request $request)
    {
        if(!empty($request->associate_id)){
            return $model->newQuery()->where('associate_id',$request->associate_id)->where('status', '!=', Quota::STATUS_CANCELED);
        }else{
            return redirect()->back();
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
            ->setTableId('quotas-table')
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
        $model = new Quota();
        return [

            Column::make('year')->title($model->getAttributeLabel('year')),
            Column::make('semester')->title($model->getAttributeLabel('semester'))->attributes(['data-options' => json_encode(Quota::getSemesterArray())]),
            Column::make('price')->title($model->getAttributeLabel('price')),
            Column::make('status')->title($model->getAttributeLabel('status'))->attributes(['data-options' => json_encode([0 => "A Aguardar Pagamento", 1 => "Pago"])]),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'quotas_' . date('YmdHis');
    }
}

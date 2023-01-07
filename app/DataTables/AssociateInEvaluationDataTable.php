<?php

namespace App\DataTables;

use App\Models\Associate;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;
use App\DataTables\Traits\DatatableColumnSearch;

class AssociateInEvaluationDataTable extends DataTable
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
            ->editColumn('category', function ($associate) {
                return $associate->getCategoryLabelAttribute();
            })
            ->editColumn('status', function ($associate) {
                return $associate->getStatusLabelAttribute();
            })
            ->addColumn('action', function ($associate) {
                return '<a class="btn btn-sm btn-bg-light btn-color-primary btn-icon" href="'. route('associates.evaluations', $associate) .'" title="'. __('Evaluate') .'">'. theme()->getSvgIcon("icons/duotune/general/gen004.svg", "svg-icon-2") .'</a>';
            })
            ->setRowClass('text-gray-600 fw-bold');
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
    public function query(Associate $model)
    {
        if(auth()->user()->can('accessAsCAC')){
            return $model->whereIn('status',[Associate::STATUS_WAITING_APPROVAL_CAC,Associate::STATUS_WAITING_ADMIN_APPROVAL,Associate::STATUS_WAITING_PAYMENT])->where('category',Associate::CATEGORY_ASSOCIADO_EFETIVO);
        }else{
            return $model->whereIn('status',[Associate::STATUS_WAITING_APPROVAL_CAC,Associate::STATUS_WAITING_ADMIN_APPROVAL,Associate::STATUS_WAITING_BASIC_APPROVAL,Associate::STATUS_WAITING_PAYMENT]);
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
            ->setTableId('associates-in-evaluation-table')
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
        $model = new Associate();
        return [
            Column::make('name')->title($model->getAttributeLabel('name')),
            Column::make('category')->title($model->getAttributeLabel('category')),
            Column::make('status')->title($model->getAttributeLabel('status')),
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

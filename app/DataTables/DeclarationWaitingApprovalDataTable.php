<?php

namespace App\DataTables;

use App\Models\Declaration;
use App\Models\DeclarationTemplate;
use http\Env\Request;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;
use App\DataTables\Traits\DatatableColumnSearch;

class DeclarationWaitingApprovalDataTable extends DataTable
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
            ->editColumn('created_at', '{!! date(\'d-m-Y H:i\', strtotime($created_at)) !!}')
            ->addColumn('associate', function ($declaration) {
                return $declaration->associate->associate_number . ' - ' . $declaration->associate->name;
            })
            ->editColumn('declaration_template_id', function ($declaration) {
                \Debugbar::error($declaration->declarationTemplate);
               return !empty($declaration->declarationTemplate) ? $declaration->declarationTemplate->name : '';
            })
            ->editColumn('status', function ($declaration) {
                return $declaration->getStatusLabelAttribute();
            })
            ->addColumn('action', function ($declaration) {
                $associate_id = $declaration->associate->id;
                return '<a class="btn btn-sm btn-bg-light btn-color-primary btn-icon" href="'. route('declarations.show', [$declaration, 'associate_id' => $associate_id]) .'" title="'. __('View') .'">'. theme()->getSvgIcon("icons/duotune/general/gen004.svg", "svg-icon-2") .'</a>
                    <a class="btn btn-sm btn-bg-light btn-color-primary btn-icon" href="'. route('declarations.edit', [$declaration, 'associate_id' => $associate_id]) .'" title="'. __('Edit') .'">'. theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-2") .'</a>
                    <button class="btn btn-sm btn-bg-light btn-color-primary btn-icon delete-confirmation" data-destroy-form-id="destroy-form-'. $declaration->id .'" data-delete-url="'. route('declarations.destroy', $declaration) .'" onclick="destroyConfirmation(this)" title="'. __('Delete') .'">'. theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-2") .'</button>';
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
     * @param \App\Models\Declaration $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Declaration $model,\Illuminate\Http\Request $request)
    {
        /*if(!empty($request['associate_id'])){
            return $model->where('associate_id',$request['associate_id']);
        }*/
        return $model->where('status',Declaration::STATUS_WAITING_APPROVAL);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('declarations-waiting-approval-table')
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
        $model = new Declaration();
        return [
            #Column::make('id')->title($model->getAttributeLabel('id'))->visible(false),
            Column::make('associate')->title($model->getAttributeLabel('associate_id')),
            Column::make('declaration_number')->title($model->getAttributeLabel('declaration_number')),
            Column::make('declaration_template_id')->title($model->getAttributeLabel('declaration_template_id'))->attributes(['data-options' => json_encode(DeclarationTemplate::all()->pluck('name','id')->toArray())]),
            Column::make('created_at')->title(__('Dia do Pedido')),
            Column::make('status')->title($model->getAttributeLabel('status'))->attributes(['data-options' => json_encode(Declaration::getStatusArray())]),
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
        return 'declarations_' . date('YmdHis');
    }
}

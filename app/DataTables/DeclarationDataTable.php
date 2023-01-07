<?php

namespace App\DataTables;

use App\Models\Declaration;
use App\Models\DeclarationTemplate;
use Carbon\Carbon;
use http\Env\Request;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;
use App\DataTables\Traits\DatatableColumnSearch;

class DeclarationDataTable extends DataTable
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
            ->filter(function ($query) {
                if(!auth()->user()->can('accessAsUser')){
                    if (!empty(request()->get('columns')[1]['search']['value'])) {
                        $query->whereHas('associate', function($q){
                            $q->where('associates.associate_number', request()->get('columns')[1]['search']['value']);
                            $q->orWhere('associates.name', 'LIKE', "%".request()->get('columns')[1]['search']['value']."%");
                        });
                    }
                    if (!empty(request()->get('columns')[4]['search']['value'])) {
                        debugbar()->error(request()->get('columns')[4]['search']['value']);
                        $query->whereHas('declarationQuestions', function($q2){
                            $q2->where('value', 'LIKE', "%".request()->get('columns')[4]['search']['value']."%");
                        });

                    }
                }
            })
            ->editColumn('created_at', '{!! date(\'d-m-Y H:i\', strtotime($created_at)) !!}')
            ->addColumn('associate', function ($declaration) {
                return $declaration->associate->associate_number . ' - ' . $declaration->associate->name;
            })
            ->addColumn('declaration_template_questions',function($declaration){
                $declarationQuestions = $declaration->declarationQuestions;
                $questions = "";
                foreach($declarationQuestions as $question){
                    if(!empty($question->declarationTemplateQuestion)){
                        if(auth()->user()->can('accessAsUser')){
                            $questions = $questions . "<span>" . $question->declarationTemplateQuestion->question . " - " . $question->value ."</span><br>";
                        }else{
                            if(str_contains($question->declarationTemplateQuestion->question,'Designação')){
                                $questions = "<span>" . $question->value ."</span><br>";
                            }
                        }
                    }
                }
                if($questions === ""){
                    if(!empty($declaration->declarationTemplate) && $declaration->declarationTemplate->id == 8){
                        return $questions;
                    }else
                        $questions = "<span>Alvará</span><br>";
                }
                return $questions;

            })
            ->editColumn('declaration_template_id', function ($declaration) {
                \Debugbar::error($declaration->declarationTemplate);
               return !empty($declaration->declarationTemplate) ? $declaration->declarationTemplate->name : '';
            })
            ->editColumn('status', function ($declaration) {
                // && $declaration->valid_until->gte(Carbon::parse($declaration->created_at)->addYear()->addMonths(11))
                if($declaration->status == Declaration::STATUS_ACTIVE){
                    return '<a href="'.route('declarations.renovate_declaration',[$declaration,'associate_id' => $declaration->associate->id]).'">Renovar</a>';
                }
                return $declaration->getStatusLabelAttribute();
            })
            ->addColumn('final_document', function ($declaration) {
                if($declaration->status == Declaration::STATUS_ACTIVE && $declaration->hasMedia('final_document')){
                    return '<a href="' .$declaration->getFirstMediaUrl('final_document') .'" target="_blank" class="btn btn-primary">'. __('Download Document') .'</a>';
                }else{
                    return '';
                }
            })
            ->addColumn('action', function ($declaration) {
                $associate_id = $declaration->associate->id;
                if(auth()->user()->can('accessAsUser')){
                    if($declaration->status == Declaration::STATUS_WAITING_PAYMENT || $declaration->status == Declaration::STATUS_WAITING_APPROVAL){
                        return '<a class="btn btn-sm btn-bg-light btn-color-primary" href="'. route('declarations.show', [$declaration, 'associate_id' => \Illuminate\Http\Request::capture()['associate_id']]) .'" title="'. __('View') .'">Ver</a>
                    <a class="btn btn-sm btn-bg-light btn-color-primary btn-icon" href="'. route('declarations.edit', [$declaration, 'associate_id' => \Illuminate\Http\Request::capture()['associate_id']]) .'" title="'. __('Edit') .'">'. theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-2") .'</a>';
                    }else{
                        return '<a class="btn btn-sm btn-bg-light btn-color-primary" href="'. route('declarations.show', [$declaration, 'associate_id' => \Illuminate\Http\Request::capture()['associate_id']]) .'" title="'. __('View') .'">Ver</a>';
                    }

                }elseif(auth()->user()->hasAnyRole('Staff|SuperAdmin')){
                    return '<a class="btn btn-sm btn-bg-light btn-color-primary" href="'. route('declarations.show', [$declaration, 'associate_id' => $associate_id]) .'" title="'. __('View') .'">Ver</a>
                        <a class="btn btn-sm btn-bg-light btn-color-primary btn-icon" href="'. route('declarations.edit', [$declaration, 'associate_id' => $associate_id]) .'" title="'. __('Edit') .'">'. theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-2") .'</a>';
                }else{
                    return '<a class="btn btn-sm btn-bg-light btn-color-primary" href="'. route('declarations.show', [$declaration, 'associate_id' => $associate_id]) .'" title="'. __('View') .'">Ver</a>';
                }
            })
            ->setRowClass('text-gray-600 fw-bold')->rawColumns(['action','final_document','declaration_template_questions','status']);
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
        if(!empty($request['associate_id'])){
            return $model->where('associate_id',$request['associate_id']);
        }
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('declarations-table')
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
        if(auth()->user()->can('accessAsUser')){
            return [
                Column::make('id')->title($model->getAttributeLabel('id'))->visible(false),
                Column::make('declaration_number')->title(__('Número')),
                Column::make('declaration_template_id')->title(__('Modelo'))->attributes(['data-options' => json_encode(DeclarationTemplate::all()->pluck('name','id')->toArray())]),
                Column::make('declaration_template_questions')->title(__('Parâmetros')),
                Column::make('final_document')->title(__('Final Document')),
                Column::make('created_at')->title(__('Data do Pedido')),
                Column::make('status')->title($model->getAttributeLabel('status'))->attributes(['data-options' => json_encode(Declaration::getStatusArray())]),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(120)
                    /*->responsivePriority(-1)*/
                    ->addClass('text-center')
                    ->title(__('Action')),
            ];
        }else{
            return [
                Column::make('id')->title($model->getAttributeLabel('id'))->visible(false),
                Column::make('associate')->title($model->getAttributeLabel('Associado')),
                Column::make('declaration_number')->title(__('Número')),
                //Column::make('associate')->title($model->getAttributeLabel('associate_id')),
                Column::make('declaration_template_id')->title(__('Modelo'))->attributes(['data-options' => json_encode(DeclarationTemplate::all()->pluck('name','id')->toArray())]),
                Column::make('declaration_template_questions')->title(__('Designação')),
                Column::make('final_document')->title(__('Final Document'))->addClass('search_disabled'),
                Column::make('created_at')->title(__('Data do Pedido'))->attributes(['data-datepicker' => 'true']),
                Column::make('status')->title($model->getAttributeLabel('status'))->attributes(['data-options' => json_encode(Declaration::getStatusArray())]),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(120)
                    /*->responsivePriority(-1)*/
                    ->addClass('text-center')
                    ->title(__('Action')),
            ];
        }

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

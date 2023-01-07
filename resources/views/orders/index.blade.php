<?php
view()->share('pageTitle', __('Orders'));
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders.index') }}
    @endsection
    @push('firstStyles')
        <link href="{{ assetCustom('/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @if(!empty($associate))
        <div class="row gy-10 gx-xl-10">
            <!--begin::Col-->
            <div class="col-xl-12">
                {{ theme()->getView('home/navbar', array('associate' => $associate,'class' => 'card-xxl-stretch mb-5 mb-xl-10')) }}
            </div>
        </div>
    @endif

    <!--begin::Card-->
    <div class="card">
        <div class="card-header justify-content-end">
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <!--begin::Export-->
                    @if(!empty(auth()->user()) && auth()->user()->hasAnyRole('Staff|SuperAdmin'))
                        @if(!empty($associate))
                            <div class="mx-4">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_generate_quota">Gerar Quotas</button>
                            </div>
                            <div class="mx-4">
                                <a href="{{route('orders.join_all_declarations',['associate' =>$associate])}}" class="btn btn-primary">Juntar Declarações</a>
                            </div>
                            <div class="mx-4">
                                <a href="{{route('orders.join_all_quotas',['associate' =>$associate])}}" class="btn btn-primary">Juntar Quotas</a>
                            </div>
                            {{--<div class="mx-4">
                                <a href="{{route('orders.join_all_payments',['associate' =>$associate])}}" class="btn btn-primary">Juntar Tudo</a>
                            </div>--}}
                        @else
                            <div class="mx-4">
                                <a href="{{route('orders.index',['payment-method' =>\App\Models\Order::PAYMENT_METHOD_WIRE_TRANSFER])}}" class="btn btn-primary">Pagamentos por transferência bancária</a>
                            </div>

                        @endif
                    @endif
                    <div id="datatable-buttons"></div>
                    <!--end::Export-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <div class="card-body pt-0">
            <!--begin::Table-->
            {{ $dataTable->table([], true) }}
            <!--end::Table-->
        </div>
    </div>
    @if(!empty($associate))
        <div class="modal fade" tabindex="-1" id="kt_modal_generate_quota">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    {!! Form::open( ['route' => ['orders.generate_quotas', ['associate' => $associate]], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
                        <div class="modal-header">
                            <h5 class="modal-title">Gerar Quotas para o associado - {{$associate->associate_number}}</h5>

                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-2x"></span>
                            </div>
                            <!--end::Close-->
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-10 col-md-4">
                                    {!! Form::label('initial_year', __('Ano de Início'), ['class' => 'form-label ']) !!}
                                    {!! Form::select('initial_year', \App\Models\Order::getYearArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('initial_year') ? 'is-invalid' : ''),'required' => true]) !!}
                                    @error('initial_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status Field -->
                                <div class="mb-10 col-md-4">
                                    {!! Form::label('start_semester', __('Semestre de Início'), ['class' => 'form-label ']) !!}
                                    {!! Form::select('start_semester', \App\Models\Order::getStartSemesterArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('start_semester') ? 'is-invalid' : ''), 'required' => true]) !!}
                                    @error('start_semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status Field -->
                                <div class="mb-10 col-md-4">
                                    {!! Form::label('end_semester', __('Quantos Semestres?'), ['class' => 'form-label ']) !!}
                                    {!! Form::select('end_semester', \App\Models\Order::getEndSemesterArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('end_semester') ? 'is-invalid' : ''), 'required' => true]) !!}
                                    @error('end_semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Gerar</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif
    <!--end::Card-->

    @push('scripts')
        <script src="{{ assetCustom('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
        {{ $dataTable->scripts() }}
        <script>

            $(function(){
                $.fn.dataTable.Buttons.defaults.dom.container.className = '';
                $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-light-primary me-3';
                var buttons = new $.fn.dataTable.Buttons(window.LaravelDataTables["orders-table"], {
                    buttons: [
                        'export',
                    ]
                }).container().appendTo($('#datatable-buttons'));
            });
            function destroyConfirmation(e){
                var _this =  jQuery(e);
                swal.fire({
                    title: '{{ __('Are you sure you want to delete this?') }}',
                    text: "{!! __("You won't be able to revert this!") !!}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Yes, delete it!') }}"
                }).then(function(result) {
                    if (result.value) {
                        //jQuery("#"+_this.data('destroy-form-id')).submit();
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        jQuery.ajax({
                            url: _this.data('delete-url'),
                            type: 'POST',
                            dataType: 'json',
                            data: {_method: 'DELETE'}
                        }).always(function (data) {
                            jQuery('#orders-table').DataTable().draw(false);
                        });
                    }
                });
            }
            var handleSearchDatatable = (datatable) => {
                const filterSearch = document.querySelector('[data-table-filter="search"]');
                filterSearch.addEventListener('keyup', function (e) {
                    datatable.search(e.target.value).draw();
                });
            }
        </script>
    @endpush
</x-base-layout>

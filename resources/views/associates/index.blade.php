<?php
view()->share('pageTitle', __('Associates'));
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('associates.index') }}
    @endsection
    @push('firstStyles')
        <link href="{{ assetCustom('/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <!--begin::Card-->
    <div class="card">
        <div class="card-header justify-content-end">
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <!--begin::Export-->
                    <div id="datatable-buttons"></div>
                    <!--begin::Trigger-->
                    <button type="button" class="btn btn-primary mx-2"
                            data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-start">
                        Pesquisas Avançadas
                        <span class="svg-icon svg-icon-5 rotate-180 ms-3 me-0">...</span>
                    </button>
                    <!--end::Trigger-->

                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
                         data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a onclick="exportData(1)" class="menu-link px-3">
                                Associados Ativos
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a onclick="exportData(2)"  class="menu-link px-3">
                                Associados com Quotas por Regularizar
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a onclick="exportData(3)" class="menu-link px-3">
                                Associados com Quotas Regularizadas
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a onclick="exportData(3)" class="menu-link px-3">
                                Associados para Seguradora
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->


                    <a href="{{ route('associates.create') }}" class="btn btn-primary">
                        {!! theme()->getSvgIcon("icons/duotune/arrows/arr075.svg", "svg-icon-2") !!}
                        {{ __('New Associate') }}
                    </a>


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
    <!--end::Card-->

    @push('scripts')
        <script src="{{ assetCustom('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
        {{ $dataTable->scripts() }}
        <script>
            $(function(){
                $.fn.dataTable.Buttons.defaults.dom.container.className = '';
                $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-light-primary me-3';
                var buttons = new $.fn.dataTable.Buttons(window.LaravelDataTables["associates-table"], {
                    buttons: [
                        'export',
                        /*{
                            extend: 'pdf',
                            //titleAttr: 'Associados Ativos',
                            text: 'Associados Ativos',
                            action: allActiveAssociates,
                            footer: true,
                            header: true,
                           /!* exportOptions: {
                                columns: ':exportable'
                            },*!/
                        },
                        {
                            extend: 'pdf',
                            //titleAttr: 'Associados com Quotas por Regularizar',
                            text: 'Associados com Quotas por Regularizar',
                            action: AssociatesWithInvalidQuotas,
                            footer: true,
                            header: true
                        },
                        {
                            extend: 'pdf',
                            //titleAttr: 'Associados com Quotas Regularizadas',
                            text: 'Associados com Quotas Regularizadas',
                            action: AssociatesWithValidQuotas,
                            footer: true,
                            header: true
                        },
                        {
                            extend: 'pdf',
                            //titleAttr: 'Associados para Seguradora',
                            text: 'Associados para Seguradora',
                            action: AssociatesWithValidQuotas,
                            footer: true,
                            header: true
                        },*/
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
                            jQuery('#associates-table').DataTable().draw(false);
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

            function exportData(value){
                $('#associates-table').DataTable().ajax.url("?export="+ value).load();
            }

            function onChangeAssociateStatus(elem,associateId){
                console.log($($(elem).find('option:selected')).val());
                console.log(associateId);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{route('associates.change_status')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {'associate' : associateId , 'status' : $($(elem).find('option:selected')).val() }
                }).then(function (result) {
                    console.log(result,associateId);
                    jQuery('#associates-table').DataTable().ajax.reload();
                });
            }
            /*var oldExportAction = function (self, e, dt, button, config) {

                if (button[0].className.indexOf('buttons-pdf') >= 0) {
                    if ($.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config)) {
                        console.log($.fn.dataTable.ext.buttons.pdfHtml5);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config);
                    }
                    else {
                        $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    }
                } else if (button[0].className.indexOf('buttons-print') >= 0) {
                    $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                }
            };*/

            /*var allActiveAssociates = function (e, dt, button, config) {
                $('#associates-table').DataTable().ajax.url("?export=1").load();
                //exportData(e, dt, button, config,this);
            };

            var AssociatesWithInvalidQuotas = function (e, dt, button, config) {
                $('#associates-table').DataTable().ajax.url("?export=2").load();
                //exportData(e, dt, button, config,this);
            };

            var AssociatesWithValidQuotas = function (e, dt, button, config) {
                $('#associates-table').DataTable().ajax.url("?export=3").load();
                //exportData(e, dt, button, config,this);
            };*/

            /*function exportData(e, dt, button, config,obj){
                var self = obj;
                var oldStart = dt.settings()[0]._iDisplayStart;

                dt.one('preXhr', function (e, s, data) {
                    // Just this once, load all data from the server...
                    data.start = 0;
                    data.length = 2147483647;

                    dt.one('preDraw', function (e, settings) {
                        // Call the original action function
                        oldExportAction(self, e, dt, button, config);

                        dt.one('preXhr', function (e, s, data) {
                            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                            // Set the property to what it was before exporting.
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });

                        // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                        setTimeout(dt.ajax.reload, 0);

                        // Prevent rendering of the full data to the DOM
                        return false;
                    });
                });

                // Requery the server with the new one-time export settings
                dt.ajax.reload();
            }*/
        </script>
    @endpush
</x-base-layout>

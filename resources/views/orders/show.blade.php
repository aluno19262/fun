<?php
/**
 *
 * @var $order \App\Models\Order
 */
view()->share('pageTitle', 'Pagamento - ' . $order->created_at->format('Y-m-d'));
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders.show', $order) }}
    @endsection
    @if(!empty($associate))
        <div class="row gy-10 gx-xl-10">
            <!--begin::Col-->
            <div class="col-xl-12">
                {{ theme()->getView('home/navbar', array('associate' => $associate,'class' => 'card-xxl-stretch mb-5 mb-xl-10')) }}
            </div>
        </div>
    @endif
    <div class="card">
        <!-- begin::Body-->
        <div class="card-body py-20">
            <!-- begin::Wrapper-->
            <div class="mw-lg-950px mx-auto w-100">
                <!-- begin::Header-->
                <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                    <h4 class="fw-boldest text-gray-800 fs-2qx pe-5 pb-7">{{__('Pagamento')}}</h4>
                    <!--end::Logo-->
                    <div class="text-sm-end">
                        <!--begin::Logo-->
                        {{--<a href="#">
                            <img alt="Logo" src="assets/media/svg/brand-logos/duolingo.svg" />
                        </a>--}}
                        <!--end::Logo-->
                        <!--begin::Text-->
                        <div class="text-sm-end fw-bold fs-4 text-dark mt-7">
                            <div>{{$order->getStatusLabelAttribute()}}</div>
                            {{--<div>Mississippi 96522</div>--}}
                        </div>
                        <div class="text-sm-end fw-bold fs-4 text-dark mt-7">
                            <div>{{$order->name }}</div>
                            <div>{{$order->vat}}</div>
                        </div>
                        <!--end::Text-->
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="border-bottom pb-12 mb-lg-20">
                    <!--begin::Image-->
                    {{--<div class="d-flex flex-row-fluid bgi-no-repeat bgi-position-x-center bgi-size-cover card-rounded h-150px h-lg-250px mb-lg-20" style="background-image: url(assets/media/misc/pattern-4.jpg)"></div>--}}
                    <!--end::Image-->
                    <!--begin::Wrapper-->
                    <div class="d-flex justify-content-between flex-column flex-md-row">
                        <!--begin::Content-->
                        <div class="flex-grow-1 pt-8 mb-13">
                            <!--begin::Table-->
                            <div class="table-responsive border-bottom mb-14">
                                <table class="table">
                                    <thead>
                                    <tr class="border-bottom fs-6 fw-bolder text-muted text-uppercase">
                                        <th class="min-w-175px pb-9">{{__('Description')}}</th>
                                        <th class="min-w-70px pb-9 text-end">{{__('Quantity')}}</th>
                                        <th class="min-w-100px pe-lg-6 pb-9 text-end">{{__('Price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="pt-11">

                                    @foreach($order->orderItems as $item)
                                        <tr class="fw-bolder text-gray-700 fs-5 text-end">
                                            <td class="d-flex align-items-center pt-4">
                                                @if(!empty($item->quota) && $item->quota->semester == 0)
                                                    <i class="fa fa-genderless text-danger fs-1 me-2"></i>{{$item->name . " - " . $item->quota->year}}</td>
                                                @elseif(!empty($item->quota) && $item->quota->semester != 0)
                                                    <i class="fa fa-genderless text-danger fs-1 me-2"></i>{{$item->name . " - " . $item->quota->semester . "º Semestre " . $item->quota->year}}</td>
                                                @else
                                                    <i class="fa fa-genderless text-danger fs-1 me-2"></i>{{$item->name}}</td>
                                                @endif
                                            <td class="pt-4">{{$item->quantity}}</td>
                                            <td class="pt-4 fs-5 pe-lg-6 text-dark fw-boldest">{{$item->price . ' €'}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                            <!--begin::Section-->
                            @if($order->status == \App\Models\Order::STATUS_WAITING_PAYMENT)
                                <div class="accordion" id="kt_accordion_1_1">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="kt_accordion_1_1_header_1">
                                            <button class="accordion-button fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_1_body_1">
                                                {{__('Multibanco')}}
                                            </button>
                                        </h2>
                                        <div id="kt_accordion_1_1_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_1_header_1" data-bs-parent="#kt_accordion_1_1">
                                            <div class="accordion-body">
                                                <div class="d-flex flex-column mw-md-300px w-100">
                                                    <!--begin::Label-->
                                                    <div class="fw-bold fs-5 mb-3 text-dark00">{{__('MB Reference')}}</div>
                                                    <!--end::Label-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                                        <!--begin::Accountnumber-->
                                                        <div class="fw-bold pe-5">{{__('Entity') . ':'}}</div>
                                                        <!--end::Accountnumber-->
                                                        <!--begin::Number-->
                                                        <div class="text-end fw-norma">{{$order->mb_ent}}</div>
                                                        <!--end::Number-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                                        <!--begin::Code-->
                                                        <div class="fw-bold pe-5">{{__('Reference') . ':'}}</div>
                                                        <!--end::Code-->
                                                        <!--begin::Label-->
                                                        <div class="text-end fw-norma">{{$order->mb_ref}}</div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                                        <!--begin::Code-->
                                                        <div class="fw-bold pe-5">{{__('Total') . ':'}}</div>
                                                        <!--end::Code-->
                                                        <!--begin::Label-->
                                                        <div class="text-end fw-norma">{{$order->total . ' €'}}</div>
                                                        <!--end::Label-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="kt_accordion_1_1_header_2">
                                            <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_1_body_2" aria-expanded="false" aria-controls="kt_accordion_1_1_body_2">
                                                {{__('MBWAY')}}
                                            </button>
                                        </h2>
                                        <div id="kt_accordion_1_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_1_header_2" data-bs-parent="#kt_accordion_1_1">
                                            <div class="accordion-body">

                                                <div class="row">
                                                    <div class="col-md-6" style="max-width: 100%;">
                                                        <div class="form-group">
                                                            <label for="phone_number">{{__('MbWay Phone Number')}}</label>
                                                            <input type="text" id="phone_number" class="form-control" placeholder="{{__('MbWay Phone Number')}}" value="{{!empty($order->associate->phone1) ? $order->associate->phone1 : ''}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 align-self-end">
                                                        <div class="d-flex font-size-sm flex-wrap">
                                                            <button type="button" id="mb_button" class="mb_button btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1" onclick="payWithMbway({{$order->id}},0)">{{__('MbWay Payment')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(false && !empty($order->total_half))
                                    <h3 class="mt-10 mb-10">Pagamento Semestral</h3>
                                    <div class="accordion" id="kt_accordion_1_2">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="kt_accordion_1_2_header_1">
                                                <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_2_body_1" aria-expanded="true" aria-controls="kt_accordion_1_2_body_1">
                                                    {{__('Multibanco')}}
                                                </button>
                                            </h2>
                                            <div id="kt_accordion_1_2_body_1" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_2_header_1" data-bs-parent="#kt_accordion_1_2">
                                                <div class="accordion-body">
                                                    <div class="d-flex flex-column mw-md-300px w-100">
                                                        <!--begin::Label-->
                                                        <div class="fw-bold fs-5 mb-3 text-dark00">{{__('MB Reference')}}</div>
                                                        <!--end::Label-->
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                                            <!--begin::Accountnumber-->
                                                            <div class="fw-bold pe-5">{{__('Entity') . ':'}}</div>
                                                            <!--end::Accountnumber-->
                                                            <!--begin::Number-->
                                                            <div class="text-end fw-norma">{{$order->mb_ent_half}}</div>
                                                            <!--end::Number-->
                                                        </div>
                                                        <!--end::Item-->
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                                            <!--begin::Code-->
                                                            <div class="fw-bold pe-5">{{__('Reference') . ':'}}</div>
                                                            <!--end::Code-->
                                                            <!--begin::Label-->
                                                            <div class="text-end fw-norma">{{$order->mb_ref_half}}</div>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Item-->
                                                        <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                                            <!--begin::Code-->
                                                            <div class="fw-bold pe-5">{{__('Total') . ':'}}</div>
                                                            <!--end::Code-->
                                                            <!--begin::Label-->
                                                            <div class="text-end fw-norma">{{$order->total_half . ' €'}}</div>
                                                            <!--end::Label-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="kt_accordion_1_2_header_2">
                                                <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_2_body_2" aria-expanded="false" aria-controls="kt_accordion_1_2_body_2">
                                                    {{__('MBWAY')}}
                                                </button>
                                            </h2>
                                            <div id="kt_accordion_1_2_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_2_header_2" data-bs-parent="#kt_accordion_1_2">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-6" style="max-width: 100%;">
                                                            <div class="form-group">
                                                                <label for="phone_number">{{__('MbWay Phone Number')}}</label>
                                                                <input type="text" id="phone_number_half" class="form-control" placeholder="{{__('MbWay Phone Number')}}" value="{{!empty($order->associate->phone1) ? $order->associate->phone1 : ''}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 align-self-end">
                                                            <div class="d-flex font-size-sm flex-wrap">
                                                                <button type="button" id="mb_button" class="mb_button btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1" onclick="payWithMbway({{$order->id}},1)">{{__('MbWay Payment')}}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($order->canDivideOrder() )
                                    {!! Form::model($order, ['route' => ['orders.divide_quota',$order], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
                                        <h3 class="mt-10 mb-10">Pagamento Fraccionado</h3>

                                        <div class="row">
                                            <div class="mb-10 col-md-6">
                                                {!! Form::label('divide', $order->getAttributeLabel('divide'), ['class' => 'form-label ']) !!}
                                                {!! Form::select('divide', $order->getDivideArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('divide') ? 'is-invalid' : '')]) !!}
                                                @error('divide')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-10 col-md-6 align-self-end">
                                                <button type="submit" class="btn btn-primary" >{{ __('Gerar Dados de Pagamento') }}</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                @endif
                            @endif
                        </div>
                            <!--end::Section-->
                        {{--</div>--}}
                        <!--end::Content-->
                        <!--begin::Separator-->
                        <div class="border-end d-none d-md-block mh-450px mx-9"></div>
                        <!--end::Separator-->
                        <!--begin::Content-->
                        <div class="text-end pt-10">
                            <!--begin::Total Amount-->
                            <div class="fs-3 fw-bolder text-muted mb-3">{{__('TOTAL AMOUNT')}}</div>
                            <div class="fs-xl-2x fs-2 fw-boldest">{{$order->total . ' €'}}</div>
                            <div class="text-muted fw-bold">{{__('Taxes included')}}</div>
                            <!--end::Total Amount-->
                            <div class="border-bottom w-100 my-7 my-lg-16"></div>
                            <!--begin::Invoice To-->
                            <div class="text-gray-600 fs-6 fw-bold mb-3">{{__('INVOICE STATUS.')}}</div>
                            <div class="fs-6 text-gray-800 fw-bold mb-8">{{$order->getInvoiceStatusLabelAttribute()}}</div>
                            <!--end::Invoice To-->
                            <!--begin::Invoice No-->
                            @if(false && !empty($order->invoice_id))
                                <div class="text-gray-600 fs-6 fw-bold mb-3">{{__('INVOICE INTERNAL NUMBER.')}}</div>
                                <div class="fs-6 text-gray-800 fw-bold mb-8">{{$order->invoice_id}}</div>
                            @endif
                            <!--end::Invoice No-->
                            <!--begin::Invoice No-->
                            @if(!empty($order->invoice_number))
                                <div class="text-gray-600 fs-6 fw-bold mb-3">{{__('INVOICE NUMBER.')}}</div>
                                <div class="fs-6 text-gray-800 fw-bold mb-8">{{$order->invoice_number}}</div>
                            @endif
                            <!--end::Invoice No-->
                            <!--begin::Invoice Date-->
                            <div class="text-gray-600 fs-6 fw-bold mb-3">{{__('DATE')}}</div>
                            <div class="fs-6 text-gray-800 fw-bold">{{$order->created_at->format('d-m-Y')}}</div>
                            @if(!empty($order->invoice_link))
                                <div class="text-gray-600 fs-6 fw-bold mb-3">{{__('INVOICE')}}</div>
                                <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13">
                                    <a href="{{$order->invoice_link}}" target="_blank" class="btn btn-primary my-1">{{__('Download Invoice')}}</a>
                                </div>
                               {{-- <div class="fs-6 text-gray-800 fw-bold"><a href="{{$order->invoice_link}}">{{__('Download')}}</a></div>--}}
                            @endif
                            <!--end::Invoice Date-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Body-->

                <!-- end::Footer-->
            </div>
            <!-- end::Wrapper-->
        </div>
        <!-- end::Body-->
    </div>


    @push('scripts')
        <script>
            var canMbway = true;
            function destroyConfirmation(e){
                swal.fire({
                    title: '{{ __('Are you sure you want to delete this?') }}',
                    text: "{!! __("You won't be able to revert this!") !!}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Yes, delete it!') }}"
                }).then(function(result) {
                    if (result.value) {
                        document.getElementById('delete-form').submit();
                    }
                });
            }

            @if($order->status == \App\Models\Order::STATUS_WAITING_PAYMENT)
                function payWithMbway(order,isHalf){
                    if(canMbway){
                        canMbway = false;
                        changeCanMbway();
                        console.log(order);
                        var phone = null;
                        if(isHalf === 0){
                            phone = $('#phone_number').val();
                            console.log('0',phone);
                        }else{
                            phone = $('#phone_number_half').val();
                            console.log('1',phone);
                        }
                        if(phone !== '' && phone != null){
                            $.ajax({
                                url : '{{route('orders.pay_with_mbway')}}' ,
                                method : "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data:{order_id: order, phone: phone,isHalf: isHalf},
                                success: function(response) {
                                    if(response.success){
                                        toastr.success('Referência gerada com sucesso');
                                    }else{
                                        canMbway = true;
                                        changeCanMbway();
                                        toastr.warning('Ocorreu um erro. Tente mais tarde.');
                                    }
                                    console.log(response);
                                }

                            });
                        }
                    }

                }
            @endif

            function changeCanMbway(){
                if(canMbway){
                    $('.mb_button').removeClass('disabled');
                    $('.mb_button').prop('disabled',false);
                }else{
                    $('.mb_button').addClass('disabled');
                    $('.mb_button').prop('disabled',true);
                }
            }

            function payQuota(semestersToPay){
                //semestersToPay is 1 or 2
                // 1 = pay 1 semester
                // 2 = pay 1 year

                swal.fire({
                    title: '{{ __('Are you sure you want to pay this quota?') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Yes, pay it!') }}"
                }).then(function(result) {
                    if (result.value) {
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        jQuery.ajax({
                            url: "{{route('quotas.pay_quotas')}}",
                            type: 'POST',
                            dataType: 'json',
                            data: {semester: semestersToPay,order_id: {{$order->id}}},
                            success: function(result){
                                console.log(result);
                                if(result.success){
                                    toastr.success('Quota Paga com sucesso');
                                    window.location.reload();
                                }else{
                                    toastr.warning('Algo correu mal. Tente novamente');
                                }
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
</x-base-layout>

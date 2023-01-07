
<!--begin::Navbar-->
<div class="card {{ $class }}">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="image-input image-input-outline @if(!$associate->hasMedia('associate_profile')) image-input-empty @endif" data-kt-image-input="false" style="background-image: url({{ assetCustom('media/avatars/blank.png') }})">
                    <!--begin::Image preview wrapper-->
                    <div id="associate-image" class="image-input-wrapper w-125px h-125px" @if($associate->hasMedia('associate_profile')) style="background-image: url('{{ $associate->getFirstMediaUrl('associate_profile') }}')" @endif></div>
                    <!--end::Image preview wrapper-->
                    @if(auth()->user()->checkPermissionToEdit($associate))
                        <!--begin::Edit button-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                               data-kt-image-input-action="change"
                               data-bs-toggle="tooltip"
                               data-bs-dismiss="click"
                               title="{{ __('Change image') }}">
                            <i class="bi bi-pencil-fill fs-7"></i>

                            <!--begin::Inputs-->
                            <input id="new_image" type="file" name="image" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="delete_image" value="{{ old('delete_image') }}" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit button-->

                        <!--begin::Cancel button-->
                        <span id="cancel-image-button" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                              data-kt-image-input-action="cancel"
                              data-bs-toggle="tooltip"
                              data-bs-dismiss="click"
                              title="{{ __('Cancel image') }}">
                             <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Cancel button-->

                        <!--begin::Remove button-->
                        <span id="remove-image-button" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                              data-kt-image-input-action="remove"
                              data-bs-toggle="tooltip"
                              data-bs-dismiss="click"
                              title="{{ __('Remove image') }}">
                             <i class="bi bi-x fs-2"></i>
                        </span>
                    @endif
                <!--end::Remove button-->
                </div>
            </div>

            <input id="image-input" type="hidden" name="image-base64" />

            <div class="modal fade" tabindex="-1" id="modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{__('Recortar imagem para adapta à imagem de perfil')}}</h5>
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-2x"></span>
                            </div>
                            <!--end::Close-->
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row">
                                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
                            <button type="button" class="btn btn-primary" id="crop">{{__('Guardar')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            @push('scripts')
                <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.js" integrity="sha512-IlZV3863HqEgMeFLVllRjbNOoh8uVj0kgx0aYxgt4rdBABTZCl/h5MfshHD9BrnVs6Rs9yNN7kUQpzhcLkNmHw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script>
                    var $modal = $('#modal');
                    var image = document.getElementById('image');
                    var cropper;
                    var isCropped = false;

                    $("body").on("change", "#new_image", function(e){
                        var files = e.target.files;
                        var done = function (url) {
                            image.src = url;
                            $modal.modal('show');
                        };
                        var reader;
                        var file;
                        var url;

                        if (files && files.length > 0) {
                            file = files[0];
                            if (URL) {
                                done(URL.createObjectURL(file));
                            } else if (FileReader) {
                                reader = new FileReader();
                                reader.onload = function (e) {
                                    done(reader.result);
                                };
                                reader.readAsDataURL(file);
                            }
                        }
                    });
                    $modal.on('shown.bs.modal', function () {
                        isCropped = false;
                        cropper = new Cropper(image, {
                            aspectRatio: 1,
                            viewMode: 3,
                            responsive: true,
                            autoCrop: true,
                            autoCropArea:0.9,
                        });
                    }).on('hidden.bs.modal', function () {
                        if(isCropped == false){
                            $("#associate-image").css("background-image", "");
                            $("#cancel-image-button").trigger('click');
                            @if(!$associate->hasMedia('associate_profile'))
                            $("#remove-image-button").trigger('click');
                            @endif
                        }
                        cropper.destroy();
                        cropper = null;
                    });
                    $("#crop").click(function(){
                        console.log("click");
                        canvas = cropper.getCroppedCanvas({
                            width: 160,
                            height: 160,
                        });
                        canvas.toBlob(function(blob) {
                            url = URL.createObjectURL(blob);
                            var reader = new FileReader();
                            reader.readAsDataURL(blob);
                            console.log("reader");
                            reader.onloadend = function() {
                                isCropped = true;
                                var base64data = reader.result;
                                $("#associate-image").css("background-image", "url('" + base64data + "')");
                                $("#image-input").val(base64data);
                                $modal.modal('hide');
                                jQuery.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                jQuery.ajax({
                                    url:'{{route('associates.save_profile_image')}}',
                                    type: 'POST',
                                    data: {image: base64data, associate: {{$associate->id}}},
                                    success: function(result){
                                        console.log("coisas",result);
                                        if(result.success){
                                            toastr.success('Imagem de perfil atualizada com sucesso.');
                                            window.location.href = result.redirect;
                                        }else{
                                            toastr.error('Ocorreu um erro. Tente novamente.');
                                        }
                                    }
                                });

                            }
                        });
                    })
                </script>
            @endpush

            @push('styles')
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.css" integrity="sha512-6QxSiaKfNSQmmqwqpTNyhHErr+Bbm8u8HHSiinMEz0uimy9nu7lc/2NaXJiUJj2y4BApd5vgDjSHyLzC8nP6Ng==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            @endpush
            <!--end::Pic-->

            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->

                        <div class="d-flex align-items-center mb-2">
                            @if(!empty($associate->associate_number))
                                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ $associate->name . " " .  '[' . $associate->associate_number . ']'}}</a>
                            @else
                                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ $associate->name}}</a>
                            @endif
                            @if($associate->status == \App\Models\Associate::STATUS_ACTIVE)
                                <a href="#">
                                    {!! theme()->getSvgIcon("icons/duotune/general/gen026.svg", "svg-icon-1 svg-icon-primary") !!}
                                </a>
                            @endif
                            @if($associate->category != \App\Models\Associate::CATEGORY_MEMBRO_HONORARIO)
                                @if($associate->status == \App\Models\Associate::STATUS_INCOMPLETE_DATA || $associate->status == \App\Models\Associate::STATUS_WAITING_PAYMENT || $associate->status == \App\Models\Associate::STATUS_WAITING_ADMIN_APPROVAL || $associate->status == \App\Models\Associate::STATUS_WAITING_APPROVAL_CAC || $associate->status == \App\Models\Associate::STATUS_WAITING_BASIC_APPROVAL)
                                    @if($associate->isReadyToSubmit())
                                        @if($associate->status == \App\Models\Associate::STATUS_INCOMPLETE_DATA)
                                            <a href="#" class="btn btn-sm btn-light-warning fw-bolder ms-2 fs-8 py-1 px-3">Perfil completo e pronto a submeter</a>
                                        @else
                                            <a href="{{$associate->status == \App\Models\Associate::STATUS_WAITING_PAYMENT ? route('orders.index',['associate_id'=> $associate->id]) : '#'}}" class="btn btn-sm btn-light-warning fw-bolder ms-2 fs-8 py-1 px-3">{{ $associate->getStatusLabelAttribute() }}</a>
                                        @endif
                                    @else
                                        <a href="#" class="btn btn-sm btn-light-warning fw-bolder ms-2 fs-8 py-1 px-3">{{ $associate->getStatusLabelAttribute() }}</a>
                                    @endif
                                @elseif($associate->status == \App\Models\Associate::STATUS_ACTIVE && !empty($associate->quota_valid_until) && \Carbon\Carbon::parse($associate->quota_valid_until)->gte(\Carbon\Carbon::today()))
                                    <a href="{{route('quotas.index',['associate_id' => $associate->id])}}" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3">{{ __('Quotas regularizadas') }}</a>
                                @elseif($associate->status == \App\Models\Associate::STATUS_ACTIVE && (empty($associate->quota_valid_until) || \Carbon\Carbon::parse($associate->quota_valid_until)->lte(\Carbon\Carbon::today())))
                                    <a href="{{route('quotas.index',['associate_id' => $associate->id])}}" class="btn btn-sm btn-light-danger fw-bolder ms-2 fs-8 py-1 px-3">{{ __('Quotas não regularizadas') }}</a>
                                @elseif($associate->status == \App\Models\Associate::STATUS_SUSPENDED)
                                    <a href="{{route('quotas.index',['associate_id' => $associate->id])}}" class="btn btn-sm btn-light-danger fw-bolder ms-2 fs-8 py-1 px-3">{{ __('Suspenso: ') . $associate->suspended_at->format('d/m/Y') }}</a>
                                @else
                                    <a href="{{route('quotas.index',['associate_id' => $associate->id])}}" class="btn btn-sm btn-light-danger fw-bolder ms-2 fs-8 py-1 px-3">{{ __('Quotas não regularizadas') }}</a>
                                @endif
                            @endif
                        </div>
                        <!--end::Name-->

                        <!--begin::Info-->
                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                            @if($associate->category != null)
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    {!! theme()->getSvgIcon("icons/duotune/communication/com006.svg", "svg-icon-4 me-1") !!}
                                    {{$associate->getCategoryLabelAttribute()}}
                                </a>
                            @endif
                                {{--<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    {!! theme()->getSvgIcon("icons/duotune/communication/com006.svg", "svg-icon-4 me-1") !!}
                                    {{$associate->getStatusLabelAttribute()}}
                                </a>--}}
                            @if(!empty($associate->location))
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    {!! theme()->getSvgIcon("icons/duotune/general/gen018.svg", "svg-icon-4 me-1") !!}
                                    {{$associate->location}}
                                </a>
                            @endif
                            @if(!empty($associate->email))
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    {!! theme()->getSvgIcon("icons/duotune/communication/com011.svg", "svg-icon-4 me-1") !!}
                                    {{ $associate->email }}
                                </a>
                            @endif
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->

                    <!--begin::Actions-->
                    <div class="d-flex my-4">
                        {{--botão de follow com todas as animações
                        <a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
                            {!! theme()->getSvgIcon("icons/duotune/arrows/arr012.svg", "svg-icon-3 d-none") !!}
                            {{ theme()->getView('partials/general/_button-indicator', array('label' => 'Contactar Associado')) }}
                        </a>--}}

                        @if(!auth()->user()->can('accessAsUser'))
                            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal_candidate_contact" >{{$associate->status == \App\Models\Associate::STATUS_INACTIVE || $associate->status == \App\Models\Associate::STATUS_ACTIVE ? __('Contactar Associado') : __('Contactar Candidato') }}</button>
                        @endif
                        <div class="modal fade" tabindex="-1" id="modal_candidate_contact">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{__('Contact Candidate')}}</h5>

                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <span class="svg-icon svg-icon-2x"></span>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    {!! Form::model($associate, ['route' => ['associates.contact_candidate',$associate], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form",'id' => 'contact_candidate']) !!}
                                    <div class="modal-body">
                                        <div class="mb-10 col-md-12">
                                            {!! Form::label('subject', __('Subject'), ['class' => 'form-label ']) !!}
                                            {!! Form::text('subject', null, ['class' => 'form-control form-control-solid '.($errors->has('subject') ? 'is-invalid' : '')]) !!}
                                            @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Name Field -->
                                        <div class="mb-10 col-md-12">
                                            {!! Form::label('message', __('Write your message'), ['class' => 'form-label ']) !!}
                                            {!! Form::textarea('message', null, ['class' => 'form-control form-control-solid '.($errors->has('message') ? 'is-invalid' : ''), 'rows' => 10]) !!}
                                            @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" onclick="$('#contact_candidate')[0].reset()">{{__('Close')}}</button>
                                        <button type="submit" class="btn btn-primary">{{__('Send')}}</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                        @if($associate->status == \App\Models\Associate::STATUS_INCOMPLETE_DATA)
                            <button {{$associate->isReadyToSubmit() ? '' : 'disabled'}} class="btn btn-sm btn-primary mx-3" onclick="sendAssociateInfo({{$associate->id}})">{{__('Submeter Candidatura')}}</button>
                            @push('scripts')
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                                <script>
                                    function sendAssociateInfo(associateId){
                                        jQuery.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        jQuery.ajax({
                                            url: "{{route('associates.send_application_to_cac')}}",
                                            type: 'POST',
                                            data: {'associate_id': associateId},
                                            success: function (result) {
                                                console.log(result);
                                                if(result.success){
                                                    toastr.success('Candidatura Submetida');
                                                    window.location.reload();
                                                }else{
                                                    toastr.error('Preencha todos os campos obrigatórios, adicione uma fotografia e os documentos exigidos.');
                                                }
                                            }
                                        });
                                    }
                                </script>
                            @endpush
                        @endif
                        @if(auth()->user()->can('manageApp') || auth()->user()->can('accessAsCAC'))
                            <!--begin::Menu-->
                            <div class="me-0 mx-5">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                {{ theme()->getView('partials/menus/_menu-3',array('associate' => $associate)) }}
                            </div>
                                <!--end::Menu-->
                        @endif

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Title-->

                <!--begin::Stats-->
                <div class="d-flex flex-wrap flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {!! theme()->getSvgIcon("icons/duotune/arrows/arr066.svg", "svg-icon-3 svg-icon-success me-2") !!}
                                    {{--<div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">{{$associate->registration_date->format('d-m-Y')}}</div>--}}
                                    @if(!empty($associate->registration_date))
                                        <div class="fs-2 fw-bolder">{{!empty($associate->registration_date) ? $associate->registration_date->format('d-m-Y') : '---'}}</div>
                                    @else
                                        <div class="fs-2 fw-bolder">---</div>
                                    @endif
                                </div>
                                <!--end::Number-->

                                <!--begin::Label-->
                                <div class="fw-bold fs-6 text-gray-400">{{ __('Associado desde') }}</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->


                            @if($associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO)
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        {!! theme()->getSvgIcon("icons/duotune/arrows/arr066.svg", "svg-icon-3 svg-icon-success me-2") !!}
                                        <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{$associate->declarations()->where('status',\App\Models\Declaration::STATUS_ACTIVE)->where('declaration_template_id','!=',8)->count()}}">{{$associate->declarations()->where('status',\App\Models\Declaration::STATUS_ACTIVE)->where('declaration_template_id','!=',8)->count()}}</div>
                                    </div>
                                    <!--end::Number-->

                                    <!--begin::Label-->
                                    <div class="fw-bold fs-6 text-gray-400">{{ __('Emited Declarations') }}</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            @endif

                            <!--begin::Stat-->
                            @if(false)
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        {!! theme()->getSvgIcon("icons/duotune/arrows/arr066.svg", "svg-icon-3 svg-icon-success me-2") !!}
                                        <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="%">0</div>
                                    </div>
                                    <!--end::Number-->

                                    <!--begin::Label-->
                                    <div class="fw-bold fs-6 text-gray-400">{{ __('Success Rate') }}</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            @endif
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->

                    @if($associate->status == \App\Models\Associate::STATUS_ACTIVE && $associate->category != \App\Models\Associate::CATEGORY_ASSOCIADO_ESTUDANTE)
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                @if(!empty($associate->quota_valid_until) && \Carbon\Carbon::parse($associate->quota_valid_until)->gte(\Carbon\Carbon::today()))
                                    <span class="fw-bold fs-6 text-gray-400">{{ __('Renovação da quota em') }}</span>
                                    <span class="fw-bolder fs-6">{{\Carbon\Carbon::parse($associate->quota_valid_until)->diffInDays(\Carbon\Carbon::today()) . ' dias'}}</span>
                                @else
                                    <span class="fw-bold fs-6 text-danger-400">{{ __('Quotas por regularizar') }}</span>
                                @endif

                            </div>
                            @php
                            $percentage = 0;
                                if(!empty($associate->quota_valid_until) && \Carbon\Carbon::parse($associate->quota_valid_until)->gte(\Carbon\Carbon::today())){
                                    $percentage = (abs(1-(floatval(\Carbon\Carbon::parse($associate->quota_valid_until)->diffInDays(\Carbon\Carbon::today())))  / 365) * 100) ;
                                    /*if(floatval(\Carbon\Carbon::parse($associate->quota_valid_until)->diffInDays(\Carbon\Carbon::today())) > 182){
                                        $percentage = (abs(1-(floatval(\Carbon\Carbon::parse($associate->quota_valid_until)->diffInDays(\Carbon\Carbon::today())))  / 365) * 100) ;
                                    }else{
                                        $percentage = ((abs(1 - floatval(\Carbon\Carbon::parse($associate->quota_valid_until)->diffInDays(\Carbon\Carbon::today()))) / 182) * 100) ;
                                    }*/
                                }else{
                                    $percentage = 100;
                                }

                            @endphp

                            <div class="h-5px mx-3 w-100 bg-light mb-3">
                                <div class="{{ $percentage > 75 ? "bg-danger" : ($percentage < 50 ? "bg-success" : "bg-warning") }} rounded h-5px" role="progressbar" style="width: {{$percentage . '%'}};" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end::Progress-->
                    @endif
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->

        <!--begin::Navs-->
        <div class="d-flex overflow-auto h-55px">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                @if($associate->user_id == auth()->user()->id && (auth()->user()->can('accessAsCAC') || auth()->user()->can('manageApp')))
                    {{--<li class="nav-item">
                        <a class="nav-link text-active-primary me-6 {{ request()->fullUrl() == route('home') ? 'active' : '' }}" href="{{ route('home') ? theme()->getPageUrl(route('home')) : '#' }}">
                            {{ __('Overview') }}
                        </a>
                    </li>--}}
                @elseif(auth()->user()->can('accessAsCAC') || auth()->user()->can('manageApp'))
                    @if($associate->status == \App\Models\Associate::STATUS_WAITING_ADMIN_APPROVAL || $associate->status == \App\Models\Associate::STATUS_WAITING_APPROVAL_CAC)
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 {{ request()->fullUrl() == route('associates.evaluations',[$associate,'associate_id' =>$associate->id]) ? 'active' : '' }}" href="{{ route('associates.evaluations',[$associate,'associate_id' =>$associate->id]) ? theme()->getPageUrl(route('associates.evaluations',[$associate,'associate_id' =>$associate->id])) : '#' }}">
                                {{ __('Evaluations') }}
                            </a>
                        </li>
                    @else
                       {{-- <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 {{ request()->fullUrl() == route('associates.show',[$associate,'associate_id' =>$associate->id]) ? 'active' : '' }}" href="{{ route('associates.show',[$associate,'associate_id' =>$associate->id]) ? theme()->getPageUrl(route('associates.show',[$associate,'associate_id' =>$associate->id])) : '#' }}">
                                {{ __('Overview') }}
                            </a>
                        </li>--}}
                    @endif

                @endif
                {{--@if(auth()->user()->can('accessAsUser'))
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 {{ request()->fullUrl() == route('home') ? 'active' : '' }}" href="{{ route('home') ? theme()->getPageUrl(route('home')) : '#' }}">
                            {{ __('Overview') }}
                        </a>
                    </li>
                @endif--}}
                <li class="nav-item">
                    <a class="nav-link text-active-primary text-dark me-6 {{ request()->fullUrl() == route('associates.edit',$associate) ? 'active' : '' }}" href="{{ route('associates.edit',$associate) ? theme()->getPageUrl(route('associates.edit',$associate)) : '#' }}">
                        {{ __('Associate Info') }}
                    </a>
                </li>
                @if(!empty($associate->company))
                    <li class="nav-item">
                        <a class="nav-link text-active-primary text-dark me-6 {{ request()->fullUrl() == route('companies.edit',[$associate->company,'associate_id' =>$associate->id]) ? 'active' : '' }}" href="{{ route('companies.edit',[$associate->company,'associate_id' =>$associate->id]) ? theme()->getPageUrl(route('companies.edit',[$associate->company,'associate_id' =>$associate->id])) : '#' }}">
                            {{ __('Company Info') }}
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-active-primary text-dark me-6 {{ request()->fullUrl() == route('companies.create',['associate_id' =>$associate->id])  ? 'active' : '' }}" href="{{ route('companies.create',['associate_id' =>$associate->id]) ? theme()->getPageUrl(route('companies.create',['associate_id' =>$associate->id])) : '#' }}">
                            {{ __('Company Info') }}
                        </a>
                    </li>
                @endif
                {{--@if($associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO && in_array($associate->status,[\App\Models\Associate::STATUS_WAITING_PAYMENT,\App\Models\Associate::STATUS_ACTIVE]) && !empty($associate->quota_valid_until) && \Carbon\Carbon::parse($associate->quota_valid_until)->gte(\Carbon\Carbon::today()) )--}}
                    @if(!empty($associate->findAp))
                        <li class="nav-item">
                            <a class="nav-link text-active-primary {{$associate->canMakeDeclaration() ? "text-dark" : "text-muted" }} me-6 {{ request()->fullUrl() == route('find-aps.edit',[$associate->findAp,'associate_id' =>$associate->id]) ? 'active' : '' }}" href="{{$associate->canMakeDeclaration() ? route('find-aps.edit',[$associate->findAp,'associate_id' =>$associate->id])  : '#' }}">
                                {{ __('Find Ap Info') }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-active-primary {{$associate->canMakeDeclaration() ? "text-dark" : "text-muted" }}  me-6 {{ request()->fullUrl() == route('find-aps.create',['associate_id' =>$associate->id])  ? 'active' : '' }}" href="{{$associate->canMakeDeclaration() ? route('find-aps.create',['associate_id' =>$associate->id])  : '#' }}">
                                {{ __('Find Ap Info') }}
                            </a>
                        </li>
                    @endif
                {{--@endif--}}
                @if((!empty(auth()->user()) && auth()->user()->hasAnyRole('Staff|SuperAdmin') && !empty($associate) && !empty($associate->user)) || (!empty($associate) && !empty($associate->user) && !empty(auth()->user()->associate) && auth()->user()->associate->id == $associate->id) )
                    <li class="nav-item">
                        <a class="nav-link text-active-primary text-dark me-6 {{ request()->fullUrl() == route('associates.preferential_contacts',['associate_id' =>$associate->id]) ? 'active' : '' }}" href="{{ route('associates.preferential_contacts',['associate_id' =>$associate->id]) ? theme()->getPageUrl(route('associates.preferential_contacts',['associate_id' =>$associate->id])) : '#' }}">
                            {{ __('Acesso e Contactos') }}
                        </a>
                    </li>
                @endif
                {{-- TODO Só deixar abrir o que está abaixo se tiver os dados de associado completos mas deixar ver na mesma as orders --}}
               {{-- @if($associate->haveCompleteAssociateData())
                    @if(!empty($associate->quota_valid_until) && \Carbon\Carbon::parse($associate->quota_valid_until)->gte(\Carbon\Carbon::today()) && $associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO)--}}
                        <li class="nav-item">
                            <a class="nav-link text-active-primary {{$associate->canMakeDeclaration() && $associate->haveCompleteAssociateData() ? "text-dark" : "text-muted" }} me-6 {{ request()->fullUrl() == route('declarations.index',['associate_id' =>$associate->id]) ? 'active' : '' }}" href="{{!empty($associate->quota_valid_until) && \Carbon\Carbon::parse($associate->quota_valid_until)->gte(\Carbon\Carbon::today()) && $associate->haveCompleteAssociateData() && $associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO ? route('declarations.index',['associate_id' =>$associate->id])  : '#'}}" >
                                {{ __('Declarations') }}
                            </a>
                        </li>
                    {{--@endif
                @endif--}}
                @if((auth()->user()->can('accessAsUser')&& in_array($associate->status,[\App\Models\Associate::STATUS_WAITING_PAYMENT,\App\Models\Associate::STATUS_ACTIVE]) ) || auth()->user()->hasAnyRole('Staff|SuperAdmin'))
                    <li class="nav-item">
                        <a class="nav-link text-active-primary text-dark me-6 {{ request()->fullUrl() == route('orders.index',['associate_id' => $associate]) ? 'active' : '' }}" href="{{ route('orders.index',['associate_id' => $associate]) ? theme()->getPageUrl(route('orders.index',['associate_id' => $associate])) : '#' }}">
                            {{ __('Orders') }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!--begin::Navs-->
    </div>
</div>
<!--end::Navbar-->


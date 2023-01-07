<x-auth-layout>
    <!--begin::Logo-->

    <!--end::Logo-->

    <!--begin::Wrapper-->
    <div class=" bg-white rounded shadow-sm p-10 p-lg-15 mx-auto {{request()->routeIs('policies.*') ? "" : "w-lg-500px"}}">
        <div class="row align-center">
            <a href="{{ route('home') }}" class="mb-12 d-flex justify-content-center">
                <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'logos/apap-logo.png') }}" class="h-125px"/>
            </a>
        </div>

        <!--begin::Heading-->
        <div class="text-center mb-5">
            <!--begin::Title-->
            <h1 class="text-dark mb-7">
                {{ __('Insira Código de Validação:') }}
            </h1>
            <!--end::Title-->

            <!--begin::Link-->
            <div class="fv-row mb-7">
                <input class="form-control form-control-lg form-control-solid" type="text" id="code" placeholder="Código de Validação"/>
            </div>
            <p id="error-message" class="text-danger d-none">Código de declaração inválido</p>

            <h1 class="text-dark mb-7">
                {{ __('Insira Número de Associado:') }}
            </h1>
            <!--end::Title-->

            <!--begin::Link-->
            <div class="fv-row mb-7">
                <input class="form-control form-control-lg form-control-solid" type="text" id="associate_number" placeholder="Número de Associado"/>
            </div>
            <p id="error-message-associate" class="text-danger d-none">Número de Associado inválido</p>

            <div class="fv-row mb-3 text-center">
                <button class="btn btn-primary" type="button" id="code-search">Pesquisar</button>
            </div>

            <!--end::Link-->
        </div>
        <div class="text-center mb-5 d-none" id="declaration-info">
            <!--begin::Title-->
            <div id="declaration_check" class="mb-7">
                <h1 class="text-dark mt-7">
                    {{ __('Declaração Válida') }}
                </h1>
                <span class="svg-icon svg-icon-success svg-icon-5x">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
                        <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black"/>
                    </svg>
                </span>
            </div>

            <div id="declaration_wrong" class="mb-7">
                <h1 class="text-dark mt-7">
                    {{ __('Declaração Inválida') }}
                </h1>
                <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen034.svg-->
                <span class="svg-icon svg-icon-danger svg-icon-5x">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
                        <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"/>
                        <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"/>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>

            <!--begin::Link-->
            <div class="fv-row mb-3 text-left" >
                <p id="declaration_number"></p>
                <p id="declaration_template"></p>
                <p id="declaration_code"></p>
                <p id="declaration_questions"></p>
                <p id="declaration_status"></p>
                <p id="declaration_quotas" class="text-danger"></p>
            </div>

            <div class="fv-row mb-3 text-center d-none" id="download_file_div">
                <a id="download_file" class="btn btn-light btn-sm" href="" target="_blank">Descarregar Declaração</a>
            </div>

            <!--end::Link-->
        </div>
    </div>




    <!--end::Signin Form-->
    @push('scripts')
        <script>
            function clearAll(){
                $('#declaration_check').addClass('d-none');
                $('#declaration_wrong').addClass('d-none');
                $('#declaration-info').addClass('d-none');
                $('#declaration_number').text('');
                $('#declaration_template').text('');
                $('#declaration_code').text('');
                $('#declaration_questions').text('');
                $('#declaration_status').text('');
                $('#declaration_quotas').text('');
                $('#download_file_div').addClass('d-none');
                $('#download_file').prop('href',"");
                $('#error-message').addClass('d-none');
            }
            $('#code-search').on('click',function(elem){
                clearAll();
                if($('#code').val() !== "" && $('#code').val().length == 14 && $('#associate_number').val() !== "" && $('#associate_number').val().length < 6){
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        url:'{{route('home.validar_declaracoes')}}',
                        type: 'POST',
                        data: {code: $('#code').val(),associate: $('#associate_number').val()},
                        success: function(result){
                            console.log(result);
                            if(result.success){
                                console.log(result);
                                var nowDate = new Date().getTime();
                                var quotaDate = new Date(result.valid_until).getTime();
                                $('#declaration-info').removeClass('d-none');
                                //console.log(nowDate,quotaDate,nowDate < quotaDate);

                                if(result.quota_valid){
                                    console.log("media:",result.quota_valid);
                                    console.log(result.media);
                                    $('#declaration_check').removeClass('d-none');
                                    $('#download_file_div').removeClass('d-none');
                                    $('#download_file').attr('href',result.media);
                                    $('#declaration_status').text("Data de Validade : " + result.valid_until);
                                }else{
                                    $('#declaration_wrong').removeClass('d-none');
                                    if(nowDate < quotaDate){
                                        $('#declaration_status').text("Data de Validade : ---");
                                    }else{
                                        $('#declaration_status').text("Data de Validade : " + result.valid_until);
                                    }
                                }
                                $('#declaration_number').text("Número da Declaração : " + result.number);
                                $('#declaration_code').text("Data de Emissão : " + result.created_at);
                                toastr.success('Código Válido');
                            }else{
                                if(result.field === "declaracao"){
                                    $('#error-message').removeClass('d-none');
                                }
                                if(result.field === "associado"){
                                    $('#error-message-associate').removeClass('d-none');
                                }

                            }
                        }
                    });
                }else{
                    toastr.error('Código inválido');
                    if($('#code').val() === "" || $('#code').val().length !== 14){
                        $('#error-message').removeClass('d-none');
                    }else{
                        $('#error-message').addClass('d-none');
                    }
                    if($('#associate_number').val() === "" || $('#associate_number').val().length > 6){
                        $('#error-message-associate').removeClass('d-none');
                    }else{
                        $('#error-message-associate').addClass('d-none');
                    }

                }
            });


        </script>
    @endpush
</x-auth-layout>



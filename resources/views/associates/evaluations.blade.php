<?php
/**
 *
 * @var $associate \App\Models\Associate
 */

view()->share('pageTitle', __('Evaluate') . ' ' . $associate->name);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('associates.evaluations', $associate) }}
    @endsection
    <div class="row gy-10 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            {{ theme()->getView('home/navbar', array('class' => 'card-xxl-stretch mb-5 mb-xl-10','associate' => $associate)) }}
        </div>
    </div>
    @if(!empty($associate))
        <div class="card mb-10" >
            <div class="accordion" id="kt_accordion_1">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_1">
                        <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                            <h4 style="font-size:1.25rem!important;font-weight: 500!important">{{__('Informação do Candidato')}}</h4>
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_1" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <!--begin::Accordion-->
                            <table class="table table-row table-row-gray-300 gy-7">
                                <tbody>
                                @if(!empty($associate->associate_number))
                                    <!-- Associate Number Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('associate_number') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->associate_number }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->category))
                                    <!-- Category Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('category') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->getCategoryLabelAttribute() }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->name))
                                    <!-- Name Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('name') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->name }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->email))
                                    <!-- Email Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('email') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->email }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->phone1))
                                    <!-- Phone1 Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('phone1') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->phone1 }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->phone2))
                                    <!-- Phone2 Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('phone2') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->phone2 }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->vat))
                                    <!-- Vat Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('vat') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->vat }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if($associate->gender !== null)
                                    <!-- Genre Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('gender') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->getGenderLabelAttribute() }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->address))
                                    <!-- Address Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('address') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->address }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->zip))
                                    <!-- Zip Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('zip') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->zip }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->location))
                                    <!-- Location Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('location') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->location }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->country))
                                    <!-- Country Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('country') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->country }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if($associate->associate_delegation !== null)
                                    <!-- Associate Delegation Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('associate_delegation') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->getAssociateDelegationLabelAttribute() }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->birthday))
                                    <!-- Birthday Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('birthday') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->birthday->format('d-m-Y') }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->registration_date))
                                    <!-- Registration Date Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('registration_date') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->registration_date->format('d-m-Y') }}</span>
                                        </div>
                                    </div>
                                @endif
                                <!-- Gdpr Compliant Field -->
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('gdpr_compliant') }}</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bolder fs-6 text-gray-800">{{ !empty($associate->gdpr_compliant) ? __('Yes') : __('No') }}</span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('gdpr_newsletter') }}</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bolder fs-6 text-gray-800">{{ !empty($associate->gdpr_newsletter) ? __('Yes') : __('No') }}</span>
                                    </div>
                                </div>
                                @if(!empty($associate->training_institute_degree))
                                    <!-- Training Institute Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('training_institute_degree') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->training_institute_degree }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($associate->cc_number))
                                    <!-- Training Institute Field -->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('cc_number') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->cc_number }}</span>
                                        </div>
                                    </div>
                                @endif
                                <!-- Quota Valid Until Field -->
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('quota_valid_until') }}</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bolder fs-6 text-gray-800">{{ !empty($associate->quota_valid_until) ? $associate->quota_valid_until->format('d-m-Y') : __('Need to buy this semester Quota') }}</span>
                                    </div>
                                </div>
                                <!-- Newsletter Field -->
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('newsletter') }}</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bolder fs-6 text-gray-800">{{!empty($associate->newsletter) ? __('Yes') : __('No') }}</span>
                                    </div>
                                </div>
                                <!-- Preferential Contact Field -->
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('preferential_contact') }}</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bolder fs-6 text-gray-800">{{ $associate->getPreferentialContactLabelAttribute() }}</span>
                                    </div>
                                </div>
                                <!-- Status Field -->
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('status') }}</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bolder fs-6 text-gray-800">{{ $associate->getStatusLabelAttribute() }}</span>
                                    </div>
                                </div>

                                @if(!empty($associate->notes) && auth()->user()->can('manageApp'))
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('notes') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->notes }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if($associate->hasMedia('associate_profile'))
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ __('Profile Image') }}</label>
                                        <div class="col-lg-8">
                                            <a href="{{$associate->getFirstMediaUrl('associate_profile')}}" target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                        </div>
                                    </div>
                                @endif
                                @if($associate->hasMedia('associate_cc'))
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ __('CC') }}</label>
                                        <div class="col-lg-8">
                                            <a href="{{$associate->getFirstMediaUrl('associate_cc')}}" target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                        </div>
                                    </div>
                                @endif
                                @if($associate->hasMedia('associate_passport'))
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ __('Passport') }}</label>
                                        <div class="col-lg-8">
                                            <a href="{{$associate->getFirstMediaUrl('associate_passport')}}" target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                        </div>
                                    </div>
                                @endif
                                @if($associate->hasMedia('associate_curriculum'))
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">{{ __('Curriculum Vitae') }}</label>
                                        <div class="col-lg-8">
                                            <a href="{{$associate->getFirstMediaUrl('associate_curriculum')}}" target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                        </div>
                                    </div>
                                @endif
                                @if(!$associate->pre_bolonha)
                                    @if($associate->hasMedia('associate_degree_certificate'))
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">{{ __('Degree Certificate') }}</label>
                                            <div class="col-lg-8">
                                                <a href="{{$associate->getFirstMediaUrl('associate_degree_certificate')}}"  target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if($associate->hasMedia('associate_master_certificate'))
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">{{ __('Master Certificate') }}</label>
                                            <div class="col-lg-8">
                                                <a href="{{$associate->getFirstMediaUrl('associate_master_certificate')}}"  target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if($associate->hasMedia('associate_degree_final_certificate'))
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">{{ __('Degree Final Certificate') }}</label>
                                            <div class="col-lg-8">
                                                <a href="{{$associate->getFirstMediaUrl('associate_degree_final_certificate')}}"  target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if($associate->hasMedia('associate_master_final_certificate'))
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">{{ __('Master Final Certificate') }}</label>
                                            <div class="col-lg-8">
                                                <a href="{{$associate->getFirstMediaUrl('associate_master_final_certificate')}}"  target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if($associate->hasMedia('associate_degree_inscription_certificate'))
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">{{ __('Degree Inscription Certificate') }}</label>
                                            <div class="col-lg-8">
                                                <a href="{{$associate->getFirstMediaUrl('associate_degree_inscription_certificate')}}"  target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if($associate->hasMedia('associate_master_inscription_certificate'))
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">{{ __('Master Inscription Certificate') }}</label>
                                            <div class="col-lg-8">
                                                <a href="{{$associate->getFirstMediaUrl('associate_master_inscription_certificate')}}"  target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if($associate->hasMedia('associate_bolonha_degree'))
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">{{ __('Licenciatura Pré-Bolonha') }}</label>
                                            <div class="col-lg-8">
                                                <a href="{{$associate->getFirstMediaUrl('associate_bolonha_degree')}}"  target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if($associate->hasMedia('associate_bolonha_degree_inscription_certificate'))
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">{{ __('Inscrição na  Licenciatura Pré-Bolonha') }}</label>
                                            <div class="col-lg-8">
                                                <a href="{{$associate->getFirstMediaUrl('associate_bolonha_degree_inscription_certificate')}}" target="_blank" class="btn btn-primary">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                </tbody>
                            </table>
                            <!--end::Accordion-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

        {{--se o processo não estiver na fase de decisão do tipo de processo--}}
    @if($associate->is_simple_process != \App\Models\Associate::PROCESS_WAITING || $associate->category != \App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO)
        {{--se estiver na fase de aprovação pela cac e mostra o form para votação--}}
        @if($associate->status == \App\Models\Associate::STATUS_WAITING_APPROVAL_CAC)
            <div class="card mb-10" >
                <div class="accordion" id="kt_accordion_2">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_2_header_1">
                            <button class="accordion-button fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_body_1" aria-expanded="true" aria-controls="kt_accordion_2_body_1">
                                <h4 style="font-size:1.25rem!important;font-weight: 500!important">{{ __('Emitir Parecer') . ' - ' . $associate->getProcessLabelAttribute()  }}
                                    @if($associate->is_simple_process == \App\Models\Associate::PROCESS_SIMPLE)
                                        <div class="text-muted fs-7 fw-bold">{{__('Requires 2 votes')}}</div>
                                    @elseif($associate->is_simple_process == \App\Models\Associate::PROCESS_COMPLEX)
                                        <div class="text-muted fs-7 fw-bold">{{__('Requires 5 votes')}}</div>
                                    @endif
                                </h4>
                            </button>
                        </h2>
                        <div id="kt_accordion_2_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_2_header_1" data-bs-parent="#kt_accordion_2">
                            <div class="accordion-body">

                                <!--begin::Accordion-->
                                {!! Form::model($associate, ['route' => ['associates.store_evaluation',$associate], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
                                <div class="card-body">
                                    {!! Form::hidden('user_id',auth()->user()->id) !!}
                                    {!! Form::hidden('associate_id',$associate->id) !!}
                                    {!! Form::hidden('phase',1) !!}
                                    <div class="d-flex">

                                        <div class="mb-10 me-10">
                                            {!! Form::label('status', __('Parecer Positivo'), ['class' => 'form-check-label ']) !!}
                                            {!! Form::radio('status', 1 , true,['class' => 'form-check-input','required' => 'required', !empty($associateEvaluationCac) && $associateEvaluationCac->status == \App\Models\AssociateEvaluation::STATUS_ACCEPTED ? 'checked' :'']) !!}
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-10">
                                            {!! Form::label('status', __('Parecer Negativo'), ['class' => 'form-check-label ']) !!}
                                            {!! Form::radio('status', 0 , true,['class' => 'form-check-input','required' => 'required',!empty($associateEvaluationCac) && $associateEvaluationCac->status == \App\Models\AssociateEvaluation::STATUS_REJECTED ? 'checked' :'' ]) !!}
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Name Field -->
                                    <div class="mb-10 col-md-12">
                                        {!! Form::label('note', __('Note'), ['class' => 'form-label ']) !!}
                                        {!! Form::textarea('note', !empty($associateEvaluationCac) ? $associateEvaluationCac->note : null, ['class' => 'form-control form-control-solid '.($errors->has('note') ? 'is-invalid' : ''), 'rows' => 2]) !!}
                                        @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary"  >{{ __('Save') }}</button>
                                </div>
                            {!! Form::close() !!}
                                <!--end::Accordion-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--apenas de o associado for efetivo e mostra as avaliações da cac--}}
        @if($associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO)
            <div class="card mb-10">
                <div class="accordion" id="kt_accordion_4">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_4_header_1">
                            <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_4_body_1" aria-expanded="true" aria-controls="kt_accordion_4_body_1">
                                <h4 style="font-size:1.25rem!important;font-weight: 500!important">{{__('Resumo dos Pareceres Emitidos')}}</h4>
                            </button>
                        </h2>
                        <div id="kt_accordion_4_body_1" class="accordion-collapse collapse" aria-labelledby="kt_accordion_4_header_1" data-bs-parent="#kt_accordion_4">
                            <div class="accordion-body">
                                <!--begin::Accordion-->
                                <table class="table table-row table-row-gray-300 gy-7">
                                    <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800">
                                        <th>{{__('User')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Note')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($associate->evaluations()->where('phase',\App\Models\AssociateEvaluation::PHASE_1)->get() as $evaluation)
                                        <tr>
                                            <td>{{$evaluation->user->name}}</td>
                                            <td>{{$evaluation->getStatusLabelAttribute()}}</td>
                                            <td>{{$evaluation->note}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end::Accordion-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--se estiver na fase de aprovação pela cac e mostra a seleção do tipo de processo--}}
        @if($associate->status == \App\Models\Associate::STATUS_WAITING_APPROVAL_CAC)
            <div class="card mb-10" >
                <div class="accordion" id="kt_accordion_3">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_3_header_1">
                            <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_3_body_1" aria-expanded="true" aria-controls="kt_accordion_3_body_1">
                                <h4 style="font-size:1.25rem!important;font-weight: 500!important">{{__('Seleção do Tipo de Processo')}}</h4>
                            </button>
                        </h2>
                        <div id="kt_accordion_3_body_1" class="accordion-collapse collapse " aria-labelledby="kt_accordion_3_header_1" data-bs-parent="#kt_accordion_3">
                            <div class="accordion-body">
                                <!--begin::Accordion-->
                                {!! Form::model($associate, ['route' => ['associates.store_process',$associate], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
                                <div class="card-body p-0">
                                {!! Form::hidden('associate_id',$associate->id) !!}
                                <!-- Name Field -->
                                    <div class="mb-5">
                                        {!! Form::select('is_simple_process', \App\Models\Associate::getProcessArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('is_simple_process') ? 'is-invalid' : ''), 'required' => true]) !!}
                                        @error('is_simple_process')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-5">
                                        <span class="text-muted">Processo Simples para candidatos com licenciatura ou mestrado em escola portuguesa reconhecida<br>Processo Complexo necessita de avaliação com dados complementares.</span>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end px-9">
                                    <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
                                </div>
                                {!! Form::close() !!}
                                <!--end::Accordion-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--se estiver na fase de aprovação pela administração--}}
        @if($associate->status == \App\Models\Associate::STATUS_WAITING_ADMIN_APPROVAL && auth()->user()->can('adminApp'))
        <!--begin::Vote-->
            <div class="card mb-10">
                <div class="accordion" id="kt_accordion_5">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_5_header_1">
                            <button class="accordion-button fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_5_body_1" aria-expanded="true" aria-controls="kt_accordion_5_body_1">
                                <h4 style="font-size:1.25rem!important;font-weight: 500!important">
                                    {{ __('Vote') . ' - ' . $associate->getProcessLabelAttribute()  }}
                                    @if($associate->is_simple_process == \App\Models\Associate::PROCESS_SIMPLE)
                                        <div class="text-muted fs-7 fw-bold">{{__('Requires 1 votes')}}</div>
                                    @elseif($associate->is_simple_process == \App\Models\Associate::PROCESS_COMPLEX)
                                        <div class="text-muted fs-7 fw-bold">{{__('Requires 5 votes')}}</div>
                                    @endif
                                </h4>
                            </button>
                        </h2>
                        <div id="kt_accordion_5_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_5_header_1" data-bs-parent="#kt_accordion_5">
                            <div class="accordion-body">
                                <!--begin::Accordion-->
                                {!! Form::model($associate, ['route' => ['associates.store_evaluation',$associate], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
                                <div class="card-body">
                                    {!! Form::hidden('user_id',auth()->user()->id) !!}
                                    {!! Form::hidden('associate_id',$associate->id) !!}
                                    {!! Form::hidden('phase',2) !!}
                                    <div class="d-flex">
                                        <div class="mb-10 me-10">
                                            {!! Form::label('status', __('Accepted'), ['class' => 'form-check-label ']) !!}
                                            {!! Form::radio('status', 1 , true,['class' => 'form-check-input','required' => 'required', !empty($associateEvaluationAdmin) && $associateEvaluationAdmin->status == \App\Models\AssociateEvaluation::STATUS_ACCEPTED ? 'checked' :''])!!}
                                        </div>
                                        <div class="mb-10">
                                            {!! Form::label('status', __('Rejected'), ['class' => 'form-check-label ']) !!}
                                            {!! Form::radio('status', 0 , true,['class' => 'form-check-input','required' => 'required', !empty($associateEvaluationAdmin) && $associateEvaluationAdmin->status == \App\Models\AssociateEvaluation::STATUS_REJECTED ? 'checked' :'']) !!}
                                        </div>
                                    </div>
                                    <!-- Name Field -->
                                    <div class="mb-10 me-10">
                                        {!! Form::label('note', __('Note'), ['class' => 'form-label ']) !!}
                                        {!! Form::textarea('note', null, ['class' => 'form-control form-control-solid '.($errors->has('note') ? 'is-invalid' : ''), 'rows' => 2]) !!}
                                        @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
                                </div>
                            {!! Form::close() !!}
                                <!--end::Accordion-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif

        {{--se estiver na fase de aprovação pela administração--}}
        @if($associate->status == \App\Models\Associate::STATUS_WAITING_BASIC_APPROVAL && auth()->user()->can('manageApp'))
        <!--begin::Vote-->
            <div class="card mb-10">
                <div class="accordion" id="kt_accordion_6">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_6_header_1">
                            <button class="accordion-button fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_6_body_1" aria-expanded="true" aria-controls="kt_accordion_6_body_1">
                                <h4 style="font-size:1.25rem!important;font-weight: 500!important">
                                    {{ __('Vote') . ' - ' . $associate->getProcessLabelAttribute()  }}
                                    @if($associate->is_simple_process == \App\Models\Associate::PROCESS_SIMPLE)
                                        <div class="text-muted fs-7 fw-bold">{{__('Requires 2 votes')}}</div>
                                    @elseif($associate->is_simple_process == \App\Models\Associate::PROCESS_COMPLEX)
                                        <div class="text-muted fs-7 fw-bold">{{__('Requires 5 votes')}}</div>
                                    @endif</h4>
                            </button>
                        </h2>
                        <div id="kt_accordion_6_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_6_header_1" data-bs-parent="#kt_accordion_6">
                            <div class="accordion-body">
                                <!--begin::Accordion-->
                                {!! Form::model($associate, ['route' => ['associates.store_evaluation',$associate], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
                                    <div class="card-body">
                                        {!! Form::hidden('user_id',auth()->user()->id) !!}
                                        {!! Form::hidden('associate_id',$associate->id) !!}
                                        {!! Form::hidden('phase',3) !!}
                                        <div class="d-flex">
                                            <div class="mb-10 me-10">
                                                {!! Form::label('status', __('Accepted'), ['class' => 'form-check-label ']) !!}
                                                {!! Form::radio('status', 1 , true,['class' => 'form-check-input','required' => 'required', !empty($associateEvaluationAdmin) && $associateEvaluationAdmin->status == \App\Models\AssociateEvaluation::STATUS_ACCEPTED ? 'checked' :''])!!}
                                            </div>
                                            <div class="mb-10">
                                                {!! Form::label('status', __('Rejected'), ['class' => 'form-check-label ']) !!}
                                                {!! Form::radio('status', 0 , true,['class' => 'form-check-input','required' => 'required', !empty($associateEvaluationAdmin) && $associateEvaluationAdmin->status == \App\Models\AssociateEvaluation::STATUS_REJECTED ? 'checked' :'']) !!}
                                            </div>
                                        </div>
                                        <!-- Name Field -->
                                        <div class="mb-10 me-10">
                                            {!! Form::label('note', __('Note'), ['class' => 'form-label ']) !!}
                                            {!! Form::textarea('note', null, ['class' => 'form-control form-control-solid '.($errors->has('note') ? 'is-invalid' : ''), 'rows' => 2]) !!}
                                            @error('note')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
                                    </div>
                                {!! Form::close() !!}
                                <!--end::Accordion-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--mostra as decisões da administração--}}
        @if($associate->evaluation_phase_2_status !== null)
        <!--begin::CAC Final Decision-->
            <div class="card mb-10">
                <div class="accordion" id="kt_accordion_7">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_7_header_1">
                            <button class="accordion-button fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_7_body_1" aria-expanded="true" aria-controls="kt_accordion_7_body_1">
                                <h4 style="font-size:1.25rem!important;font-weight: 500!important">{{ __('Admin Final Decision') }}</h4>
                            </button>
                        </h2>
                        <div id="kt_accordion_7_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_7_header_1" data-bs-parent="#kt_accordion_7">
                            <div class="accordion-body">
                                <!--begin::Accordion-->
                                <table class="table table-row table-row-gray-300 gy-7">
                                    <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800">
                                        <th>{{__('User')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Note')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$associate->evaluationPhaseTwoUser->name}}</td>
                                        <td>{{$associate->getEvaluationPhase2StatusLabelAttribute()}}</td>
                                        <td>{{$associate->evaluation_note}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--end::Accordion-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        {{--se o processo estiver em fase de decisão do tipo de processo--}}
        @if(auth()->user()->can('accessAsCAC'))
            <div class="card mb-10">
                <div class="accordion" id="kt_accordion_8">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_8_header_1">
                            <button class="accordion-button fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_8_body_1" aria-expanded="true" aria-controls="kt_accordion_8_body_1">
                                <h4 style="font-size:1.25rem!important;font-weight: 500!important">{{ __('Seleção do Tipo de Processo') }}</h4>
                            </button>
                        </h2>
                        <div id="kt_accordion_8_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_8_header_1" data-bs-parent="#kt_accordion_8">
                            <div class="accordion-body">
                                {!! Form::model($associate, ['route' => ['associates.store_process',$associate], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
                                    <div class="card-body">
                                    {!! Form::hidden('associate_id',$associate->id) !!}
                                    <!-- Name Field -->
                                        <div class="mb-5">
                                            {{-- {!! Form::label('is_simple_process', $associate->getAttributeLabel('is_simple_process'), ['class' => 'form-label ']) !!}--}}
                                            {!! Form::select('is_simple_process', \App\Models\Associate::getProcessArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('is_simple_process') ? 'is-invalid' : ''), 'required' => true]) !!}
                                            @error('is_simple_process')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <span class="text-muted">Processo Simples para candidatos com licenciatura ou mestrado em escola portuguesa reconhecida<br>Processo Complexo necessita de avaliação com dados complementares.</span>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    @endif


</x-base-layout>

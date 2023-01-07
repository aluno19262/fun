@if(!empty($associate->company_id))
    <!-- Company Id Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('company_id') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->company_id }}</span>
        </div>
    </div>
@endif

@if(!empty($associate->find_ap_id))
    <!-- Find Ap Id Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('find_ap_id') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->find_ap_id }}</span>
        </div>
    </div>
@endif

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
<!-- Gender Field -->
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
@if(!empty($associate->parish))
<!-- Parish Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('parish') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $associate->parish }}</span>
    </div>
</div>
@endif
@if(!empty($associate->municipality))
<!-- Municipality Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('municipality') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $associate->municipality }}</span>
    </div>
</div>
@endif
@if(!empty($associate->district))
<!-- District Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('district') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $associate->district }}</span>
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

@if(!empty($associate->training_institute))
    <!-- Training Institute Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $associate->getAttributeLabel('training_institute') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $associate->training_institute }}</span>
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

@if($associate->hasMedia('associate_profile'))
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ __('Profile Image') }}</label>
        <div class="col-lg-8">
            <a href="{{$associate->getFirstMediaUrl('associate_profile')}}" class="btn btn-primary">{{ __('Download') }}</a>
        </div>
    </div>
@endif
@if($associate->hasMedia('associate_cc'))
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ __('CC') }}</label>
        <div class="col-lg-8">
            <a href="{{$associate->getFirstMediaUrl('associate_cc')}}" class="btn btn-primary">{{ __('Download') }}</a>
        </div>
    </div>
@endif
@if($associate->hasMedia('associate_passport'))
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ __('Passport') }}</label>
        <div class="col-lg-8">
            <a href="{{$associate->getFirstMediaUrl('associate_passport')}}" class="btn btn-primary">{{ __('Download') }}</a>
        </div>
    </div>
@endif
@if($associate->hasMedia('associate_curriculum'))
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ __('Curriculum Vitae') }}</label>
        <div class="col-lg-8">
            <a href="{{$associate->getFirstMediaUrl('associate_curriculum')}}" class="btn btn-primary">{{ __('Download') }}</a>
        </div>
    </div>
@endif
@if(!$associate->pre_bolonha)
    @if($associate->hasMedia('associate_degree_certificate'))
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ __('Degree Certificate') }}</label>
            <div class="col-lg-8">
                <a href="{{$associate->getFirstMediaUrl('associate_degree_certificate')}}" class="btn btn-primary">{{ __('Download') }}</a>
            </div>
        </div>
    @endif
    @if($associate->hasMedia('associate_master_certificate'))
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ __('Master Certificate') }}</label>
            <div class="col-lg-8">
                <a href="{{$associate->getFirstMediaUrl('associate_master_certificate')}}" class="btn btn-primary">{{ __('Download') }}</a>
            </div>
        </div>
    @endif
    @if($associate->hasMedia('associate_degree_final_certificate'))
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ __('Degree Final Certificate') }}</label>
            <div class="col-lg-8">
                <a href="{{$associate->getFirstMediaUrl('associate_degree_final_certificate')}}" class="btn btn-primary">{{ __('Download') }}</a>
            </div>
        </div>
    @endif
    @if($associate->hasMedia('associate_master_final_certificate'))
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ __('Master Final Certificate') }}</label>
            <div class="col-lg-8">
                <a href="{{$associate->getFirstMediaUrl('associate_master_final_certificate')}}" class="btn btn-primary">{{ __('Download') }}</a>
            </div>
        </div>
    @endif
    @if($associate->hasMedia('associate_degree_inscription_certificate'))
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ __('Degree Inscription Certificate') }}</label>
            <div class="col-lg-8">
                <a href="{{$associate->getFirstMediaUrl('associate_degree_inscription_certificate')}}" class="btn btn-primary">{{ __('Download') }}</a>
            </div>
        </div>
    @endif
    @if($associate->hasMedia('associate_master_inscription_certificate'))
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ __('Master Inscription Certificate') }}</label>
            <div class="col-lg-8">
                <a href="{{$associate->getFirstMediaUrl('associate_master_inscription_certificate')}}" class="btn btn-primary">{{ __('Download') }}</a>
            </div>
        </div>
    @endif
@else
    @if($associate->hasMedia('associate_bolonha_degree'))
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ __('Licenciatura Pré-Bolonha') }}</label>
            <div class="col-lg-8">
                <a href="{{$associate->getFirstMediaUrl('associate_bolonha_degree')}}" class="btn btn-primary">{{ __('Download') }}</a>
            </div>
        </div>
    @endif
    @if($associate->hasMedia('associate_bolonha_degree_inscription_certificate'))
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ __('Inscrição na  Licenciatura Pré-Bolonha') }}</label>
            <div class="col-lg-8">
                <a href="{{$associate->getFirstMediaUrl('associate_bolonha_degree_inscription_certificate')}}" class="btn btn-primary">{{ __('Download') }}</a>
            </div>
        </div>
    @endif
@endif



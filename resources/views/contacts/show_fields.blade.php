<!-- Contact Id Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('contact_id') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $contact->contact_id }}</span>
    </div>
</div>


<!-- Associate Id Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('associate_id') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ !empty($contact->associate_id) ? $contact->associate->name . " [$contact->associate_id]" : ""}}</span>
    </div>
</div>


<!-- User Id Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('user_id') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ !empty($contact->user_id) ? $contact->user->name . " [$contact->user_id]" : "" }}</span>
    </div>
</div>


<!-- Name Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('name') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $contact->name }}</span>
    </div>
</div>


<!-- Email Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('email') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $contact->email }}</span>
    </div>
</div>


<!-- Phone Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('phone') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $contact->phone }}</span>
    </div>
</div>


<!-- Subject Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('subject') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $contact->subject }}</span>
    </div>
</div>


<!-- Type Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('type') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $contact->getTypeLabelAttribute() }}</span>
    </div>
</div>


<!-- Message Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('message') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $contact->message }}</span>
    </div>
</div>


<!-- Read At Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('read_at') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ !empty($contact->read_at) ? $contact->read_at->format('d-m-Y') : '' }}</span>
    </div>
</div>


<!-- Status Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $contact->getAttributeLabel('status') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $contact->getStatusLabelAttribute() }}</span>
    </div>
</div>



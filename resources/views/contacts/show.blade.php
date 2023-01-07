<?php
/**
 *
 * @var $contact \App\Models\Contact
 */
view()->share('pageTitle', $contact->id);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('contacts.show', $contact) }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $contact->id }}
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-sm btn-flex btn-light-primary me-2">
                    {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
                    {{ __('Update') }}
                </a>
                <button class="btn btn-sm btn-flex btn-light-danger" onclick="destroyConfirmation(this)">
                    {!! theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3") !!}
                    {{ __('Delete') }}
                </button>
                {!! Form::open(['route' => ['contacts.destroy', $contact], 'method' => 'delete', 'class'=>"d-none", 'id' => 'delete-form']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="card-body">
            @include('contacts.show_fields')
        </div>
        @if(!empty($contact->contacts))
            <div class="card-body">
                <h3 class="card-title">{{__('Answers')}}</h3>
                @foreach($contact->contacts as $answer)
                    <div class="d-flex justify-content-start mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column align-items-start">
                            <!--begin::User-->
                            <div class="d-flex align-items-center mb-2">
                                <!--begin::Avatar-->
                                @if(!empty($answer->associate))
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="{{$answer->associate->hasMedia('profile_image') ? $answer->associate->getFirstImageUrl('profile_image') : ''}}">
                                    </div>
                                @elseif(!empty($answer->user))
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="{{$answer->user->hasMedia('profile_image') ? $answer->user->getFirstImageUrl('profile_image') : ''}}">
                                    </div>
                                @endif
                                <!--end::Avatar-->
                                <!--begin::Details-->
                                <div class="ms-3">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                    <span class="text-muted fs-7 mb-1">5 Hours</span>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::User-->
                            <!--begin::Text-->
                            <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">Company BBQ to celebrate the last quater achievements and goals. Food and drinks provided</div>
                            <!--end::Text-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    @push('scripts')
        <script>
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
        </script>
    @endpush
</x-base-layout>

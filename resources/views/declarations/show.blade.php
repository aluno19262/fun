<?php
/**
 *
 * @var $declaration \App\Models\Declaration
 */
view()->share('pageTitle', $declaration->id);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('declarations.show', $declaration) }}
    @endsection

    <div class="row gy-10 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            {{ theme()->getView('home/navbar', array('associate' => $associate,'class' => 'card-xxl-stretch mb-5 mb-xl-10')) }}
        </div>
    </div>

    <div class="card">
        @if(auth()->user()->hasAnyRole('Staff|SuperAdmin'))
            <div class="card-header">
                <h3 class="card-title">
                    @if(!empty($declaration->declarationTemplate))
                        {{ $declaration->declarationTemplate->name }}
                    @endif
                </h3>
                <div class="card-toolbar">
                    @if($declaration->status == \App\Models\Declaration::STATUS_WAITING_APPROVAL)
                        <a href="{{ route('declarations.validate', [$declaration, 'associate_id' => $declaration->associate->id]) }}" class="btn btn-sm btn-flex btn-light-primary me-2">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen026.svg-->
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen037.svg-->
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
                                    <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Svg Icon-->
                            {{--{!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}--}}
                            {{ __('Validate') }}
                        </a>
                    @endif
                    {{--<a href="{{ route('declarations.convert_word', $declaration) }}" class="btn btn-sm btn-flex btn-light-primary me-2">
                        {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
                        {{ __('Download word') }}
                    </a>--}}
                    <a href="{{ route('declarations.edit', [$declaration, 'associate_id' => $declaration->associate->id]) }}" class="btn btn-sm btn-flex btn-light-primary me-2">
                        {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
                        {{ __('Update') }}
                    </a>
                    <button class="btn btn-sm btn-flex btn-light-danger" onclick="destroyConfirmation(this)">
                        {!! theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3") !!}
                        {{ __('Delete') }}
                    </button>
                    {!! Form::open(['route' => ['declarations.destroy', $declaration], 'method' => 'delete', 'class'=>"d-none", 'id' => 'delete-form']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @elseif(auth()->user()->can('accessAsUser') && $declaration->status == \App\Models\Declaration::STATUS_WAITING_PAYMENT)
            <div class="card-header">
                <h3 class="card-title">
                    {{ $declaration->id }}
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('declarations.edit', [$declaration, 'associate_id' => $declaration->associate->id]) }}" class="btn btn-sm btn-flex btn-light-primary me-2">
                        {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
                        {{ __('Update') }}
                    </a>
                    {!! Form::open(['route' => ['declarations.destroy', $declaration], 'method' => 'delete', 'class'=>"d-none", 'id' => 'delete-form']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

        @endif
        <div class="card-body">
            @include('declarations.show_fields')
        </div>
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

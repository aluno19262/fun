<?php
/**
 *
 * @var $declarationTemplate \App\Models\DeclarationTemplate
 */
view()->share('pageTitle', $declarationTemplate->name);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('declaration_templates.show', $declarationTemplate) }}
    @endsection

    <div class="card">
        <div class="card-header">
            {{--<h3 class="card-title">
                {{ $declarationTemplate->name }}
            </h3>--}}
            @if(auth()->user()->can('manageApp'))
                <div class="card-toolbar">
                    <a href="{{ route('declaration_templates.edit', $declarationTemplate) }}" class="btn btn-sm btn-flex btn-light-primary me-2">
                        {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
                        {{ __('Update') }}
                    </a>
                    <button class="btn btn-sm btn-flex btn-light-danger" onclick="destroyConfirmation(this)">
                        {!! theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3") !!}
                        {{ __('Delete') }}
                    </button>
                    {!! Form::open(['route' => ['declaration_templates.destroy', $declarationTemplate], 'method' => 'delete', 'class'=>"d-none", 'id' => 'delete-form']) !!}
                    {!! Form::close() !!}
                </div>
            @endif
        </div>
        <div class="card-body">
            @include('declaration_templates.show_fields')
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

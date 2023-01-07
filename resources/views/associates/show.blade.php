<?php
/**
 *
 * @var $associate \App\Models\Associate
 */

view()->share('pageTitle', $associate->name);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('associates.show', $associate) }}
    @endsection
    <div class="row gy-10 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            {{ theme()->getView('home/navbar', array('class' => 'card-xxl-stretch mb-5 mb-xl-10','associate' => $associate)) }}
        </div>
    </div>
    <div class="card">
        {{--<div class="card-header">
            <h3 class="card-title">
                {{ $associate->name . '[' . $associate->associate_number . ']' }}
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('associates.edit', $associate) }}" class="btn btn-sm btn-flex btn-light-primary me-2">
                    {!! theme()->getSvgIcon("icons/duotune/art/art005.svg", "svg-icon-3") !!}
                    {{ __('Update') }}
                </a>
                <button class="btn btn-sm btn-flex btn-light-danger" onclick="destroyConfirmation(this)">
                    {!! theme()->getSvgIcon("icons/duotune/general/gen027.svg", "svg-icon-3") !!}
                    {{ __('Delete') }}
                </button>
                {!! Form::open(['route' => ['associates.destroy', $associate], 'method' => 'delete', 'class'=>"d-none", 'id' => 'delete-form']) !!}
                {!! Form::close() !!}
            </div>
        </div>--}}
        <div class="card-body">
            @include('associates.show_fields')
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

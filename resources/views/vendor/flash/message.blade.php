@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @if(false)
            @include('flash::modal', [
                'modalClass' => 'flash-modal',
                'title'      => $message['title'],
                'body'       => $message['message']
            ])
        @endif
    @else
        <!--begin::Alert-->
        <div class="alert {{ $message['important'] ? 'alert-dismissible' : '' }} alert-{{ $message['level'] }} d-flex flex-column flex-sm-row p-5 mb-10">
            <!--begin::Icon-->
            {{--<span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">...</span>--}}
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-center pe-0 pe-sm-10">
                <!--begin::Title-->
                {{--<h4 class="mb-2 light">This is an alert</h4>--}}
                <!--end::Title-->

                <!--begin::Content-->
                <span>{!! $message['message'] !!}</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
            @if ($message['important'])

                <!--begin::Close-->
                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                   <span class="svg-icon svg-icon-2x svg-icon-{{ $message['level'] }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </button>
                <!--end::Close-->
            @endif
        </div>
        <!--end::Alert-->
    @endif
@endforeach
@push('scripts')
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        @foreach (session('flash_notification', collect())->toArray() as $message)
            @if ($message['overlay'] == true)
                @switch($message['level'])
                    @case('success')
                        toastr.success('{{ $message['message'] }}');
                    @break
                    @case('info')
                        toastr.info('{{ $message['message'] }}');
                    @break
                    @case('warning')
                        toastr.warning('{{ $message['message'] }}');
                    @break
                    @case('error')
                    @case('danger')
                        toastr.error('{{ $message['message'] }}');
                    @break
                    @default
                        toastr.success('{{ $message['message'] }}');
                @endswitch

            @endif
        @endforeach
    </script>
@endpush

{{ session()->forget('flash_notification') }}

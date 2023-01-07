<x-base-layout>
    @if(\Illuminate\Support\Facades\Session::has('message'))
        @push('scripts')
            <script>
                toastr.error("{{\Illuminate\Support\Facades\Session::get('message')}}", {'showDuration': 50000,'timeOut': 50000,"extendedTimeOut": "60000"})
            </script>
        @endpush
    @endif
    @include('home.stats')
</x-base-layout>



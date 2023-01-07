<x-base-layout>
    @if(\Illuminate\Support\Facades\Session::has('message'))
        @push('scripts')
            <script>
                toastr.error("{{\Illuminate\Support\Facades\Session::get('message')}}", {'showDuration': 50000,'timeOut': 50000,"extendedTimeOut": "60000"})
            </script>
        @endpush
    @endif
    @if(auth()->user()->can('manageApp'))
        @include('home.stats')
    @elseif(!empty(auth()->user()->associate) && auth()->user()->can('accessAsUser'))
        @php
            $associate = auth()->user()->associate;
        @endphp
        <div class="row gy-10 gx-xl-10">
            <!--begin::Col-->
            <div class="col-xl-12">
                {{ theme()->getView('home/navbar', array('associate' => $associate,'class' => 'card-xxl-stretch mb-5 mb-xl-10')) }}
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @include('associates.show_fields')
            </div>
        </div>
    @endif
</x-base-layout>



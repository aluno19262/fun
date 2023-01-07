@push('styles')
    <style>
        select[readonly]{
            background: #eee;
            cursor:no-drop;
        }

        select[readonly] option{
            display:none;
        }
    </style>
@endpush



@if(!auth()->user()->can('accessAsUser'))
    <div class="row">
        <!-- Associate Number Field -->
        <div class="mb-10 col-md-4">
            {!! Form::label('associate_number', $associate->getAttributeLabel('associate_number') . ' *', ['class' => 'form-label ']) !!}
            {!! Form::text('associate_number', null, ['class' => 'form-control form-control-solid '.($errors->has('associate_number') ? 'is-invalid' : ''),'maxlength' => 255,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            @error('associate_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Registration Date Field -->
        <div class="mb-10 col-md-4">
            {!! Form::label('registration_date', $associate->getAttributeLabel('registration_date'), ['class' => 'form-label']) !!}
            <div class="position-relative d-flex align-items-center">
                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black"></path>
                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black"></path>
                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black"></path>
                </svg>
            </span>
                <!--begin::Datepicker-->
            {!! Form::text('registration_date', null, ['class' => 'form-control form-control-solid ps-12 '.($errors->has('registration_date') ? 'is-invalid' : ''), 'placeholder' => __('Pick a date') ,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            <!--end::Datepicker-->
            </div>
            @error('registration_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @push('scripts')
            <script>
                $(function(){
                    $("#registration_date").flatpickr({locale: "pt",format:"DD-MM-YYYY"});
                });
            </script>
        @endpush
        <div class="mb-10 col-md-4">
            {!! Form::label('category', $associate->getAttributeLabel('category'), ['class' => 'form-label ']) !!}
            {!! Form::select('category', \App\Models\Associate::getCategoryArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('category') ? 'is-invalid' : ''), 'required' => true,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
@else
    {!! Form::hidden('category',$associate->category) !!}
@endif

<div class="row">
    <!-- Name Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('name', $associate->getAttributeLabel('name') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('name', null, ['class' => 'form-control form-control-solid '.($errors->has('name') ? 'is-invalid' : ''),'maxlength' => 255,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-10 col-md-4">
        {!! Form::label('gender', $associate->getAttributeLabel('gender') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::select('gender', \App\Models\Associate::getGenderArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('gender') ? 'is-invalid' : ''), 'required' => true,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('email', $associate->getAttributeLabel('email') . ' *', ['class' => 'form-label']) !!}

        {!! Form::email('email', null, ['class' => 'form-control form-control-solid '.($errors->has('email') ? 'is-invalid' : ''),'maxlength' => 128,empty($associate->email) || auth()->user()->checkPermissionToEdit($associate)  ? '' : 'readonly']) !!}
        @if(!empty($associate->user))
            <span class="text-muted">Este email está associado aos seus dados de acesso. Para os editar, aceda <a href="{{route('users.edit',$associate->user)}}">aqui</a>.</span>
        @endif
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <!-- Phone1 Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('phone1', $associate->getAttributeLabel('phone1') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('phone1', null, ['class' => 'form-control form-control-solid '.($errors->has('phone1') ? 'is-invalid' : ''),'maxlength' => 32,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('phone1')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <!-- Phone2 Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('phone2', $associate->getAttributeLabel('phone2'), ['class' => 'form-label ']) !!}
        {!! Form::text('phone2', null, ['class' => 'form-control form-control-solid '.($errors->has('phone2') ? 'is-invalid' : ''),'maxlength' => 32,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('phone2')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Birthday Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('birthday', $associate->getAttributeLabel('birthday') . ' *', ['class' => 'form-label']) !!}
        <div class="position-relative d-flex align-items-center {{ ($errors->has('birthday') ? 'is-invalid' : '') }}">
            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black"></path>
                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black"></path>
                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black"></path>
                </svg>
            </span>
                <!--begin::Datepicker-->
            {!! Form::text('birthday', null, ['class' => 'form-control form-control-solid ps-12 '.($errors->has('birthday') ? 'is-invalid' : ''), 'placeholder' => __('Pick a date') ,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            <!--end::Datepicker-->
        </div>
        @error('birthday')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @push('scripts')
        <script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
        <script>
            $(function(){
                $("#birthday").flatpickr({
                    maxDate: "today",
                    locale : "pt",
                });
            });
        </script>
    @endpush



</div>
<div class="row">
    <div class="mb-10 col-md-4">
        {!! Form::label('nationality', $associate->getAttributeLabel('nationality'), ['class' => 'form-label ']) !!}
        {!! Form::select('nationality', \DvK\Laravel\Vat\Facades\Countries::all() , null , ['id'=> "nationality_select",'class' => 'form-select form-select-solid '.($errors->has('nationality') ? 'is-invalid' : ''), 'required' => true,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('nationality')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Vat Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('vat', $associate->getAttributeLabel('vat') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('vat', null, ['class' => 'form-control form-control-solid '.($errors->has('vat') ? 'is-invalid' : ''),'maxlength' => 32,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('vat')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Training Institute Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('cc_number', $associate->getAttributeLabel('cc_number') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('cc_number', null, ['class' => 'form-control form-control-solid '.($errors->has('cc_number') ? 'is-invalid' : ''),'maxlength' => 255,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        <div class=" mt-4">
            <span class="text-muted">Exemplo: 12233456 7 ZZ0</span>
        </div>
        @error('cc_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
        jQuery(document).ready(function() {
            console.log($("#vat").val().includes($("#nationality_select")));
            if(!$("#nationality_select").find('option:selected').val().includes("PT") && !$("#vat").val().includes($("#nationality_select").find('option:selected').val() ) && $("#vat").val().length  == 0){
                var vat = $("#vat").val();
                $("#vat").val($("#nationality_select").find('option:selected').val()  + vat);
            }else if($("#nationality_select").find('option:selected').val().includes("PT")){
                $("#vat").val( $("#vat").val().replace('PT',""));
            }
        });
        var previous;

        $("#nationality_select").on('focus', function () {
            // Store the current value on focus and on change
            previous = this.value;
        }).change(function() {
            // Do something with the previous value after the change
            console.log(previous);
            //alert(previous + " - " +previous.length);
            // Make sure the previous value is updated
            previous = this.value;
            if($("#vat").val().length <= 2){
                $("#vat").val("");
            }
            var value = $("#vat").val();
            console.log('--inicio---')
            if($("#vat").val().includes(previous)){
                var new_value = $("#nationality_select").find('option:selected').val();
                if(!new_value === "PT"){
                    console.log('if 1');
                    $("#vat").val(value.replace(previous,$("#nationality_select").find('option:selected').val()));
                }else{
                    console.log('if 2');
                    $("#vat").val(value.replace(previous,""));
                }
            }else{
                if($("#nationality_select").find('option:selected').val() === 'PT'){
                    $("#vat").val($("#vat").val().replace('PT',""));
                }else{
                    $("#vat").val($("#nationality_select").find('option:selected').val() + $("#vat").val().replace(previous,""));
                }
            }

        });
    </script>
@endpush






<div class="row">
    <!-- Address Field -->
    <div class="mb-10 col-md-5">
        {!! Form::label('address', $associate->getAttributeLabel('address') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('address', null, ['class' => 'form-control form-control-solid '.($errors->has('address') ? 'is-invalid' : ''),'maxlength' => 512,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Zip Field -->
    <div class="mb-10 col-md-2">
        {!! Form::label('zip', $associate->getAttributeLabel('zip') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('zip', null, ['class' => 'form-control form-control-solid '.($errors->has('zip') ? 'is-invalid' : ''),'maxlength' => 16, 'oninput' => 'zipChange(this)',auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('zip')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-10 col-md-5">
        {!! Form::label('location', $associate->getAttributeLabel('location') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('location', null, ['class' => 'form-control form-control-solid '.($errors->has('location') ? 'is-invalid' : ''),'maxlength' => 128,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
<div class="row">
    <!-- Country Field -->
    <div class="mb-10 col-12">
        {!! Form::label('country', $associate->getAttributeLabel('country') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('country', null, ['class' => 'form-control form-control-solid '.($errors->has('country') ? 'is-invalid' : ''),'maxlength' => 128,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('country')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <!-- Associate Delegation Field -->
    <div class="mb-10 col-md-12">
        {!! Form::label('associate_delegation', $associate->getAttributeLabel('associate_delegation') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::select('associate_delegation', \App\Models\Associate::getAssociateDelegationArray() , null, ['class' => 'form-select form-select-solid '.($errors->has('associate_delegation') ? 'is-invalid' : ''),'maxlength' => 255,'readonly' ]) !!}
        @error('associate_delegation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="mb-10  align-self-center">
    <div class="form-check form-check-custom form-check-solid">
        {!! Form::hidden('pre_bolonha', 0) !!}
        {!! Form::checkbox('pre_bolonha', '1', null,['id' =>'pre_bolonha','class' => 'form-check-input',auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        {!! Form::label('pre_bolonha', $associate->getAttributeLabel('pre_bolonha'), ['class' => 'form-check-label']) !!}
    </div>
</div>
@push('scripts')
    <script>
        $('#pre_bolonha').on('change',function(elem){
            console.log($(this).prop('checked'));
            if($(this).prop('checked')){
                $('#training_institute_master').parent().hide();
                $('#training_institute_master_other').hide();
                $('#training_institute_master').val('');
                $('#training_institute_master_other input').val('');

                //$('#is_bolonha_docs').removeClass('d-none');
                $('#not_bolonha_docs').addClass('d-none');

                /*if($('#training_institute_degree').val().trim() === "Outro"){
                    $('#bolonha_degree_inscription').removeClass('d-none');
                }
                $('#habilitacoes_licenciatura').addClass('d-none');
                $('#habilitacoes_mestrado').addClass('d-none');*/
            }else{
                $('#training_institute_master').parent().show();
                $('#training_institute_master_other').show();


                //$('#is_bolonha_docs').addClass('d-none');
                $('#not_bolonha_docs').removeClass('d-none');
                /*if($('#training_institute_degree').val() == "Outro"){
                    $('#habilitacoes_licenciatura').removeClass('d-none');
                }
                if($('#training_institute_master').val() == "Outro"){
                    $('#habilitacoes_mestrado').removeClass('d-none');
                }*/
            }
        })
    </script>
@endpush
<div class="row">
    <!-- Training Institute Degree Field -->
    <div class="mb-10 col-md-6">
        {!! Form::label('training_institute_degree', $associate->getAttributeLabel('training_institute_degree') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::select('training_institute_degree', \App\Models\Associate::getTrainingInstituteDegreeArray() , null , ['id'=> 'training_institute_degree','class' => 'form-select form-select-solid '.($errors->has('training_institute_degree') ? 'is-invalid' : ''),  'placeholder' => ' Selecione uma Instituição de Ensino',auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('training_institute_degree')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div id="training_institute_degree_other" class="mb-10 col-md-6 {{ old('training_institute_degree', $associate->training_institute_degree) === "Outro" ? "" : "d-none" }}">
        {!! Form::label('training_institute_degree_other', $associate->getAttributeLabel('training_institute_degree_other'), ['class' => 'form-label ']) !!}
        {!! Form::text('training_institute_degree_other', null, ['class' => 'form-control form-control-solid '.($errors->has('training_institute_degree_other') ? 'is-invalid' : ''),'maxlength' => 128,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('training_institute_degree_other')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
<div class="row">
    <!-- Training Institute Master Field -->
    <div class="mb-10 col-md-6" style="{{ old('pre_bolonha', $associate->pre_bolonha) == true ? "display:none;" : "" }}">
        {!! Form::label('training_institute_master', $associate->getAttributeLabel('training_institute_master') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::select('training_institute_master', \App\Models\Associate::getTrainingInstituteMasterArray() , null , ['id'=> 'training_institute_master','class' => 'form-select form-select-solid '.($errors->has('training_institute_master') ? 'is-invalid' : ''), 'placeholder' => ' Selecione uma Instituição de Ensino',auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('training_institute_master')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div id="training_institute_master_other" class="mb-10 align-right col-md-6 {{ old('training_institute_master', $associate->training_institute_master) === "Outro" ? "" : "d-none" }}" style="{{ old('pre_bolonha', $associate->pre_bolonha) == true ? "display:none;" : "" }}">
        {!! Form::label('training_institute_master_other', $associate->getAttributeLabel('training_institute_master_other'), ['class' => 'form-label ']) !!}
        {!! Form::text('training_institute_master_other', null, ['class' => 'form-control form-control-solid '.($errors->has('training_institute_master_other') ? 'is-invalid' : ''),'maxlength' => 128,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('training_institute_master_other')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

@push('scripts')
    <script>
        $('#training_institute_degree').on('change',function(){
            if($(this).val().trim() === "Outro"){
                $('#training_institute_degree_other').removeClass('d-none');
                $('#bolonha_degree_inscription').removeClass('d-none');
                $('#habilitacoes_licenciatura').removeClass('d-none');
            }else{
                $('#training_institute_degree_other').addClass('d-none');
                $('#training_institute_degree_other input').val('');
                $('#bolonha_degree_inscription').addClass('d-none');
                $('#habilitacoes_licenciatura').addClass('d-none');
            }
        });
        $('#training_institute_master').on('change',function(){
            if($(this).val().trim() === "Outro"){
                $('#training_institute_master_other').removeClass('d-none');
                $('#habilitacoes_mestrado').removeClass('d-none');
            }else{
                $('#training_institute_master_other').addClass('d-none');
                $('#training_institute_master_other input').val('');
                $('#habilitacoes_mestrado').addClass('d-none');
            }
        });
    </script>
@endpush
{!! Form::hidden('gdpr_compliant',$associate->gdpr_compliant ? 1 : 0) !!}
{!! Form::hidden('preferential_contact',!empty($associate->preferential_contact) ? $associate->preferential_contact : \App\Models\Associate::PREFERENTIAL_CONTACT_PERSONAL_EMAIL) !!}


    <div class="row">
        <!-- Newsletter Field -->
        <div class="mb-10 col-md-6 col-sm-6  align-self-center">
            <div class="form-check form-check-custom form-check-solid">
                {!! Form::hidden('newsletter', 0) !!}
                {!! Form::checkbox('newsletter', '1', null,['class' => 'form-check-input',auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
                {!! Form::label('newsletter', $associate->getAttributeLabel('newsletter'), ['class' => 'form-check-label']) !!}
            </div>
        </div>
        @if(!auth()->user()->can('accessAsUser') && $associate->status != \App\Models\Associate::STATUS_ACTIVE)
            <div class="mb-10 col-md-6 col-sm-6  align-self-center">
                <div class="form-check form-check-custom form-check-solid">
                    {!! Form::hidden('gdpr_newsletter', 0) !!}
                    {!! Form::checkbox('gdpr_newsletter', '1', null,['class' => 'form-check-input',auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
                    {!! Form::label('gdpr_newsletter', $associate->getAttributeLabel('gdpr_newsletter'), ['class' => 'form-check-label']) !!}
                </div>
            </div>
        @else
            {!! Form::hidden('gdpr_newsletter',$associate->gdpr_newsletter ? 1 : 0) !!}
        @endif
    </div>
@if($associate->status == \App\Models\Associate::STATUS_INCOMPLETE_DATA)
    @if($associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO)
        <div class="fs-5 text-dark fw-bold mb-10">Para se candidatar a Associado Efetivo é necessário fornecer os seguintes documentos:
            <ul>
                {{--<li>Fotografia (,jpg ou .png);</li>--}}
                <li>Carregar fotografia no topo desta página.</li>
                <li>Documento de Identificação Válido (Cartão de Cidadão ou Passaporte);</li>
                <li>CV - Curriculum Vitae;</li>
                <li>Certidão de Grau de Licenciado ou Grau de Mestre – nota final*</li>
                <li>Certificado de Habilitações de Licenciatura ou Mestrado – cadeiras e notas* **</li>
            </ul>
            * Os documentos usados para o processo de inscrição são em formato digital (.jpg, .png ou .pdf), tendo as admissões carácter condicional até à recepção por correio dos originais, das fotocópias autenticadas ou serem reconhecidas presencialmente pelo secretariado da APAP.<br>
            ** Não é necessária a apresentação deste documento para os cursos das escolas portuguesas reconhecidos pela APAP.
        </div>
    @elseif($associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_ESTUDANTE)
        <div class="fs-5 text-dark fw-bold mb-10">Para se candidatar a Associado Estudante é necessário fornecer os seguintes documentos:
            <ul>
                {{--<li>Fotografia (,jpg ou .png);</li>--}}
                <li>Carregar fotografia no topo desta página.</li>
                <li>Documento de Identificação Válido (Cartão de Cidadão ou Passaporte);</li>
                <li>Comprovativo de Inscrição em Licenciatura ou Mestrado de um programa reconhecido pela APAP (ver lista aqui).</li>
            </ul>
            * Os documentos usados para o processo de inscrição são em formato digital (.jpg, .png ou .pdf), tendo as admissões carácter condicional até à recepção por correio dos originais, das fotocópias autenticadas ou serem reconhecidas presencialmente pelo secretariado da APAP.<br>
            ** Não é necessária a apresentação deste documento para os cursos das escolas portuguesas reconhecidos pela APAP.
        </div>
    @elseif($associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_ADERENTE)
        <div class="fs-5 text-dark fw-bold mb-10">Para se candidatar a Associado Aderente é necessário fornecer os seguintes documentos:
            <ul>
                {{--<li>Fotografia (,jpg ou .png);</li>--}}
                <li>Carregar fotografia no topo desta página.</li>
                <li>Documento de Identificação Válido (Cartão de Cidadão ou Passaporte);</li>
                <li>CV - Curriculum Vitae;</li>
                <li>Certidão de Grau de Licenciado ou Grau de Mestre – nota final*</li>
                <li>Certificado de Habilitações de Licenciatura ou Mestrado – cadeiras e notas* **</li>
            </ul>
            * Os documentos usados para o processo de inscrição são em formato digital (.jpg, .png ou .pdf), tendo as admissões carácter condicional até à recepção por correio dos originais, das fotocópias autenticadas ou serem reconhecidas presencialmente pelo secretariado da APAP.<br>
            ** Não é necessária a apresentação deste documento para os cursos das escolas portuguesas reconhecidos pela APAP.
        </div>
    @endif
@endif

{{--<div class="row">
    <label class="form-label">{{__('Profile Image *')}}</label>
    <div class="mb-10">

        <!--begin::Image input-->
        <div class="image-input image-input-outline @if(!$associate->hasMedia('associate_profile')) image-input-empty @endif" data-kt-image-input="false" style="background-image: url({{ assetCustom('media/avatars/blank.png') }})">
            <!--begin::Image preview wrapper-->
            <div id="associate-image-1" class="image-input-wrapper w-125px h-125px" @if($associate->hasMedia('associate_profile')) style="background-image: url('{{ $associate->getFirstMediaUrl('associate_profile') }}')" @endif></div>
            <!--end::Image preview wrapper-->
            @if(auth()->user()->checkPermissionToEdit($associate))
            <!--begin::Edit button-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                       data-kt-image-input-action="change"
                       data-bs-toggle="tooltip"
                       data-bs-dismiss="click"
                       title="{{ __('Change image') }}">
                    <i class="bi bi-pencil-fill fs-7"></i>

                    <!--begin::Inputs-->
                    <input id="new_image_1" type="file" name="image-1" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="delete_image-1" value="{{ old('delete_image_1') }}" />
                    <!--end::Inputs-->
                </label>
                <!--end::Edit button-->

                <!--begin::Cancel button-->
                <span id="cancel-image-button-1" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                      data-kt-image-input-action="cancel"
                      data-bs-toggle="tooltip"
                      data-bs-dismiss="click"
                      title="{{ __('Cancel image') }}">
                     <i class="bi bi-x fs-2"></i>
                </span>
                <!--end::Cancel button-->

                <!--begin::Remove button-->
                <span id="remove-image-button-1" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                      data-kt-image-input-action="remove"
                      data-bs-toggle="tooltip"
                      data-bs-dismiss="click"
                      title="{{ __('Remove image') }}">
                     <i class="bi bi-x fs-2"></i>
                </span>
            @endif
            <!--end::Remove button-->
        </div>
        <!--end::Image input-->
    </div>
</div>
<input id="image-input-1" type="hidden" name="image-base64" />

<div class="modal fade" tabindex="-1" id="modal-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Recortar imagem para adapta à imagem de perfil')}}</h5>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal-1" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <img id="image-1" src="https://avatars0.githubusercontent.com/u/3456749">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal-1">{{__('Close')}}</button>
                <button type="button" class="btn btn-primary" id="crop-1">{{__('Guardar')}}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.js" integrity="sha512-IlZV3863HqEgMeFLVllRjbNOoh8uVj0kgx0aYxgt4rdBABTZCl/h5MfshHD9BrnVs6Rs9yNN7kUQpzhcLkNmHw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var $modal = $('#modal-1');
        console.log($modal);
        var image = document.getElementById('image-1');
        var cropper1;
        var isCropped = false;

        $("body").on("change", "#new_image_1", function(e){
            var files1 = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };
            var reader1;
            var file;
            var url;
            if (files1 && files1.length > 0) {
                file = files1[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader1 = new FileReader();
                    reader1.onload = function (e) {
                        done(reader1.result);
                    };
                    reader1.readAsDataURL(file);
                }
            }
        });
        $modal.on('shown.bs.modal', function () {
            console.log('passa aqui');
            isCropped = false;
            cropper1 = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                responsive: true,
                /*preview: '.preview',*/
                autoCrop: true,
                autoCropArea:0.9,
                ready: function (e) {
                    $(this).cropper('setData', {
                        height: 300,
                        rotate: 0,
                        scaleX: 1,
                        scaleY: 1,
                        width:  300,
                        x:      150,
                        y:      19
                    });
                }
            });
        }).on('hidden.bs.modal', function () {
            if(isCropped == false){
                $("#associate-image-1").css("background-image", "");
                $("#cancel-image-button-1").trigger('click');
                @if(!$associate->hasMedia('associate_profile'))
                    $("#remove-image-button-1").trigger('click');
                @endif
            }
            cropper1.destroy();
            cropper1 = null;
        });
        $("#crop-1").click(function(){
            canvas1 = cropper1.getCroppedCanvas({
                width: 160,
                height: 160,
            });
            canvas1.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader1 = new FileReader();
                reader1.readAsDataURL(blob);
                reader1.onloadend = function() {
                    isCropped = true;
                    var base64data = reader1.result;
                    $("#associate-image-1").css("background-image", "url('" + base64data + "')");
                    $("#image-input-1").val(base64data);
                    $modal.modal('hide');
                }
            });
        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.css" integrity="sha512-6QxSiaKfNSQmmqwqpTNyhHErr+Bbm8u8HHSiinMEz0uimy9nu7lc/2NaXJiUJj2y4BApd5vgDjSHyLzC8nP6Ng==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush--}}

<div class="row">
    <div class="mb-10 {{!empty($associate->getFirstMedia('associate_cc')) ? 'col-md-8' : 'col-md-12' }}">
        {!! Form::label('associate_cc', __('CC/Passaporte') . "*", ['class' => 'form-label ']) !!}
        {!! Form::file('associate_cc', ['class' => 'form-control '.($errors->has('associate_cc') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('associate_cc')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @if(!empty($associate->getFirstMedia('associate_cc')))
        <div class="mb-10 col-md-4 align-self-end">
            <a class="btn bg-primary text-white" href="{{$associate->getFirstMediaUrl('associate_cc')}}" target="_blank">{{__('Download') . " " . !empty($associate->getFirstMedia('associate_cc')) ? $associate->getFirstMedia('associate_cc')->name : ''}}</a>
        </div>
    @endif
</div>
{{--<div class="row">
    <div class="mb-10 {{!empty($associate->getFirstMedia('associate_passport')) ? 'col-md-8' : 'col-md-12' }}">
        {!! Form::label('associate_passport', $associate->getAttributeLabel('associate_passport'), ['class' => 'form-label ']) !!}
        {!! Form::file('associate_passport', ['class' => 'form-control '.($errors->has('associate_passport') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('associate_passport')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @if(!empty($associate->getFirstMedia('associate_passport')))
        <div class="mb-10 col-md-4 align-self-end">
            <a class="btn bg-primary text-white" href="{{$associate->getFirstMediaUrl('associate_passport')}}" target="_blank">{{__('Download') . " " . !empty($associate->getFirstMedia('associate_passport')) ? $associate->getFirstMedia('associate_passport')->name : ''}}</a>
        </div>
    @endif
</div>--}}
<div class="row">
    <div class="mb-10 {{!empty($associate->getFirstMedia('associate_curriculum')) ? 'col-md-8' : 'col-md-12' }}">
        {!! Form::label('associate_curriculum', $associate->getAttributeLabel('associate_curriculum') . "*", ['class' => 'form-label ']) !!}
        {!! Form::file('associate_curriculum', ['class' => 'form-control '.($errors->has('associate_curriculum') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('associate_curriculum')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @if(!empty($associate->getFirstMedia('associate_curriculum')))
        <div class="mb-10 col-md-4 align-self-end">
            <a class="btn bg-primary text-white" href="{{$associate->getFirstMediaUrl('associate_curriculum')}}" target="_blank">{{__('Download') . " " . !empty($associate->getFirstMedia('associate_passport')) ? $associate->getFirstMedia('associate_curriculum')->name : ''}}</a>
        </div>
    @endif
</div>
@if($associate->category != \App\Models\Associate::CATEGORY_ASSOCIADO_ESTUDANTE)
    <div class="row">
        <div class="mb-10 {{!empty($associate->getFirstMedia('associate_degree_final_certificate')) ? 'col-md-8' : 'col-md-12' }}">
            {!! Form::label('associate_degree_final_certificate', $associate->getAttributeLabel('associate_degree_final_certificate') . "*", ['class' => 'form-label ']) !!}
            {!! Form::file('associate_degree_final_certificate', ['class' => 'form-control '.($errors->has('associate_degree_final_certificate') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            @error('associate_degree_final_certificate')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if(!empty($associate->getFirstMedia('associate_degree_final_certificate')))
            <div class="mb-10 col-md-4 align-self-end">
                <a class="btn bg-primary text-white" href="{{$associate->getFirstMediaUrl('associate_degree_final_certificate')}}" target="_blank">{{__('Download') . " " . !empty($associate->getFirstMedia('associate_degree_final_certificate')) ? $associate->getFirstMedia('associate_degree_final_certificate')->name : ''}}</a>
            </div>
        @endif
    </div>
    <div id="habilitacoes_licenciatura" class="row {{ old('training_institute_degree', $associate->training_institute_degree) == "Outro" ? "" : "d-none" }}">
        <div  class="mb-10 {{!empty($associate->getFirstMedia('associate_degree_certificate')) ? 'col-md-8' : 'col-md-12' }} ">
            {!! Form::label('associate_degree_certificate', $associate->getAttributeLabel('associate_degree_certificate') . "*" , ['class' => 'form-label ']) !!}
            {!! Form::file('associate_degree_certificate', ['class' => 'form-control '.($errors->has('associate_degree_certificate') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            @error('associate_degree_certificate')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if(!empty($associate->getFirstMedia('associate_degree_certificate')))
            <div class="mb-10 col-md-4 align-self-end">
                <a class="btn bg-primary text-white" href="{{$associate->getFirstMediaUrl('associate_degree_certificate')}}" target="_blank">{{__('Download') . " " . !empty($associate->getFirstMedia('associate_degree_certificate')) ? $associate->getFirstMedia('associate_degree_certificate')->name : ''}}</a>
            </div>
        @endif
    </div>
    <div id="not_bolonha_docs" class="{{ old('pre_bolonha', $associate->pre_bolonha) == true ? "d-none" : "" }}">
        <div class="row">
            <div class="mb-10 {{!empty($associate->getFirstMedia('associate_master_final_certificate')) ? 'col-md-8' : 'col-md-12' }}">
                {!! Form::label('associate_master_final_certificate', $associate->getAttributeLabel('associate_master_final_certificate'), ['class' => 'form-label ']) !!}
                {!! Form::file('associate_master_final_certificate', ['class' => 'form-control '.($errors->has('associate_master_final_certificate') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
                @error('associate_master_final_certificate')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if(!empty($associate->getFirstMedia('associate_master_final_certificate')))
                <div class="mb-10 col-md-4 align-self-end">
                    <a class="btn bg-primary text-white" href="{{$associate->getFirstMediaUrl('associate_master_final_certificate')}}" target="_blank">{{__('Download') . " " . !empty($associate->getFirstMedia('associate_master_final_certificate')) ? $associate->getFirstMedia('associate_master_final_certificate')->name : ''}}</a>
                </div>
            @endif
        </div>
        <div id="habilitacoes_mestrado" class="row {{ old('training_institute_degree', $associate->training_institute_master) == "Outro" ? "" : "d-none" }}">
            <div class="mb-10 {{!empty($associate->getFirstMedia('associate_master_certificate')) ? 'col-md-8' : 'col-md-12' }}">
                {!! Form::label('associate_master_certificate', $associate->getAttributeLabel('associate_master_certificate') . "*", ['class' => 'form-label ']) !!}
                {!! Form::file('associate_master_certificate', ['class' => 'form-control '.($errors->has('associate_master_certificate') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
                @error('associate_master_certificate')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if(!empty($associate->getFirstMedia('associate_master_certificate')))
                <div class="mb-10 col-md-4 align-self-end">
                    <a class="btn bg-primary text-white" href="{{$associate->getFirstMediaUrl('associate_master_certificate')}}" target="_blank">{{__('Download') . " " . !empty($associate->getFirstMedia('associate_master_certificate')) ? $associate->getFirstMedia('associate_master_certificate')->name : ''}}</a>
                </div>
            @endif
        </div>
    </div>
@endif
@if($associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_ESTUDANTE)
    <div class="row" >
        <div class="mb-10 {{!empty($associate->getFirstMedia('associate_degree_inscription_certificate')) ? 'col-md-8' : 'col-md-12' }}">
            {!! Form::label('associate_degree_inscription_certificate', $associate->getAttributeLabel('associate_degree_inscription_certificate'), ['class' => 'form-label ']) !!}
            {!! Form::file('associate_degree_inscription_certificate', ['class' => 'form-control '.($errors->has('associate_degree_inscription_certificate') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            @error('associate_degree_inscription_certificate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if(!empty($associate->getFirstMedia('associate_degree_inscription_certificate')))
            <div class="mb-10 col-md-4 align-self-end">
                <a class="btn bg-primary text-white" href="{{$associate->getFirstMediaUrl('associate_degree_inscription_certificate')}}" target="_blank">{{__('Download') . " " . !empty($associate->getFirstMedia('associate_degree_inscription_certificate')) ? $associate->getFirstMedia('associate_degree_inscription_certificate')->name : ''}}</a>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="mb-10 {{!empty($associate->getFirstMedia('associate_master_inscription_certificate')) ? 'col-md-8' : 'col-md-12' }}">
            {!! Form::label('associate_master_inscription_certificate', $associate->getAttributeLabel('associate_master_inscription_certificate'), ['class' => 'form-label ']) !!}
            {!! Form::file('associate_master_inscription_certificate', ['class' => 'form-control '.($errors->has('associate_master_inscription_certificate') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            @error('associate_master_inscription_certificate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if(!empty($associate->getFirstMedia('associate_master_inscription_certificate')))
            <div class="mb-10 col-md-4 align-self-end">
                <a class="btn bg-primary text-white" href="{{$associate->getFirstMediaUrl('associate_master_inscription_certificate')}}" target="_blank">{{__('Download') . " " . !empty($associate->getFirstMedia('associate_master_inscription_certificate')) ? $associate->getFirstMedia('associate_master_inscription_certificate')->name : ''}}</a>
            </div>
        @endif
    </div>
@endif
@if(auth()->user()->hasAnyRole('SuperAdmin|Staff'))
    <div class="row">

        <div class="mb-10 col-md-4">
            {!! Form::label('quota_valid_until', $associate->getAttributeLabel('quota_valid_until'), ['class' => 'form-label']) !!}
            <div class="position-relative d-flex align-items-center">
                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black"></path>
                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black"></path>
                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black"></path>
                </svg>
            </span>
                <!--begin::Datepicker-->
            {!! Form::text('quota_valid_until', null, ['id' => 'quota_valid_until','class' => 'form-control form-control-solid ps-12 '.($errors->has('quota_valid_until') ? 'is-invalid' : ''), 'placeholder' => __('Pick a date') ,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            <!--end::Datepicker-->
            </div>
            @error('quota_valid_until')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @push('scripts')
            <script>
                jQuery(document).ready(function() {
                    $("#quota_valid_until").flatpickr({
                        locale : "pt",
                        format: 'dd-mm-yyyy'
                    });
                });
            </script>
        @endpush
        <!-- Preferential Contact Field -->
        <div class="mb-10 col-md-4">
            {!! Form::label('preferential_contact', $associate->getAttributeLabel('preferential_contact'), ['class' => 'form-label ']) !!}
            {!! Form::select('preferential_contact', \App\Models\Associate::getPreferentialContactArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('preferential_contact') ? 'is-invalid' : ''), 'required' => true,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            @error('preferential_contact')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status Field -->
        <div class="mb-10 col-md-4">
            {!! Form::label('status', $associate->getAttributeLabel('status'), ['class' => 'form-label ']) !!}
            {!! Form::select('status', \App\Models\Associate::getStatusArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('status') ? 'is-invalid' : ''), 'required' => true,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-10 col-md-4">
        {!! Form::label('suspended_at', $associate->getAttributeLabel('suspended_at'), ['class' => 'form-label']) !!}
        <div class="position-relative d-flex align-items-center">
            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black"></path>
                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black"></path>
                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black"></path>
                </svg>
            </span>
            <!--begin::Datepicker-->
        {!! Form::text('suspended_at', null, ['id' => 'suspended_at','class' => 'form-control form-control-solid ps-12 '.($errors->has('suspended_at') ? 'is-invalid' : ''), 'placeholder' => __('Pick a date') ,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        <!--end::Datepicker-->
        </div>
        @error('suspended_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @push('scripts')
        <script>
            jQuery(document).ready(function() {
                $("#suspended_at").flatpickr({
                    locale : "pt",
                    format: 'dd-mm-yyyy'
                });
            });
        </script>
    @endpush
    <div class="mb-10">
        {!! Form::label('notes', $associate->getAttributeLabel('notes'), ['class' => 'form-label ']) !!}
        {!! Form::textarea('notes', null , ['class' => 'form-control form-control-solid '.($errors->has('notes') ? 'is-invalid' : ''),auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endif

@push('scripts')
    <script>
        function zipChange(elem){
            console.log($(elem).val());
            if($(elem).val() != null && $(elem).val().length === 8 ){
                console.log('dentro' + $(elem).val());
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url:'{{route('associates.get_zip_delegation')}}',
                    type: 'GET',
                    data: {zip: $(elem).val()},
                    success: function(result){
                        console.log(result);
                        if(result.success){
                            $('#associate_delegation').val(result.delegation);
                        }
                    }
                });
            }else{
                $('#associate_delegation').val('Sede');
            }
        }
    </script>
@endpush



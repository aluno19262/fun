<?php
view()->share('pageTitle', __('Find Aps'));
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    {{--@section('breadcrumbs')
        {{ Breadcrumbs::render('find-aps.index') }}
    @endsection--}}
        @push('styles')

        @endpush

    <!--begin::Card-->
    <div class="card">
        <div class="card-header">

            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <!--begin::Export-->

                    <!--end::Export-->
                    {{--https://maps.googleapis.com/maps/api/js/GeocodeService.Search?4sentroncamento&7sUS&9spt-PT&callback=_xdc_._zaj5az&key=AIzaSyDXzBTF-Yuf-hGqZlZzsdR_f6j24HPjtXI&token=41272--}}


                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <div class="card-body pt-0">
            {{--<div class="row">
                <!-- Associate Delegation Field -->
                <div class="mb-10 col-md-12">
                    {!! Form::label('location', __('Location'), ['class' => 'form-label ']) !!}
                    {!! Form::select('location', \App\Models\FindAp::getLocationArray() , null, ['class' => 'form-select form-select-solid '.($errors->has('location') ? 'is-invalid' : '') ]) !!}
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10 col-md-12">
                    {!! Form::label('specialty', __('Specialty'), ['class' => 'form-label ']) !!}
                    {!! Form::select('specialty', \App\Models\Associate::getSpecialtyArray() , null, ['class' => 'form-select form-select-solid '.($errors->has('specialty') ? 'is-invalid' : ''),'maxlength' => 255,'readonly' ]) !!}
                    @error('specialty')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>--}}

            <div id="map" style="width: 320px; height: 480px;"></div>
            <div>
                <input id="address" type="textbox" value="Sydney, NSW">
                <input type="button" value="Encode" onclick="codeAddress()">
            </div>

            <p id="result">Find aps : {{$findAps}}</p>
            <!--begin::Table-->

            <!--end::Table-->
        </div>
    </div>
    <!--end::Card-->

    @push('scripts')
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
            {{--https://maps.google.com/maps/geo?output=xml&key=AIzaSyDXzBTF-Yuf-hGqZlZzsdR_f6j24HPjtXI&q=Rua+Arnaldo+da+Silva%2C+n%C2%BA17%2C+2330-052%2C+Entroncamento%2C+Portugal
            https://maps.googleapis.com/maps/api/js?output=xml&key=AIzaSyDXzBTF-Yuf-hGqZlZzsdR_f6j24HPjtXI&q=Rua+Arnaldo+da+Silva%2C+n%C2%BA17%2C+2330-052%2C+Entroncamento%2C+Portugal--}}
        <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXzBTF-Yuf-hGqZlZzsdR_f6j24HPjtXI&callback=initMap&v=weekly" async></script>
        <script>
            let map;
            let marker;
            let geocoder;
            let responseDiv;
            let response;

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 8,
                    center: { lat: -34.397, lng: 150.644 },
                    mapTypeControl: false,
                });
                geocoder = new google.maps.Geocoder();

                const inputText = document.createElement("input");

                inputText.type = "text";
                inputText.placeholder = "Enter a location";

                const submitButton = document.createElement("input");

                submitButton.type = "button";
                submitButton.value = "Geocode";
                submitButton.classList.add("button", "button-primary");

                const clearButton = document.createElement("input");

                clearButton.type = "button";
                clearButton.value = "Clear";
                clearButton.classList.add("button", "button-secondary");
                response = document.createElement("pre");
                response.id = "response";
                response.innerText = "";
                responseDiv = document.createElement("div");
                responseDiv.id = "response-container";
                responseDiv.appendChild(response);

                const instructionsElement = document.createElement("p");

                instructionsElement.id = "instructions";
                instructionsElement.innerHTML =
                    "<strong>Instructions</strong>: Enter an address in the textbox to geocode or click on the map to reverse geocode.";
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputText);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(submitButton);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(clearButton);
                map.controls[google.maps.ControlPosition.LEFT_TOP].push(instructionsElement);
                map.controls[google.maps.ControlPosition.LEFT_TOP].push(responseDiv);
                marker = new google.maps.Marker({
                    map,
                });
                map.addListener("click", (e) => {
                    geocode({ location: e.latLng });
                });
                submitButton.addEventListener("click", () =>
                    geocode({ address: inputText.value })
                );
                clearButton.addEventListener("click", () => {
                    clear();
                });
                clear();
            }

            function clear() {
                marker.setMap(null);
                responseDiv.style.display = "none";
            }

            function geocode(request) {
                clear();
                geocoder
                    .geocode(request)
                    .then((result) => {
                        const { results } = result;
                        console.log(results)
                        map.setCenter(results[0].geometry.location);
                        marker.setPosition(results[0].geometry.location);
                        marker.setMap(map);
                        responseDiv.style.display = "block";
                        response.innerText = JSON.stringify(result, null, 2);
                        return results;
                    })
                    .catch((e) => {
                        alert("Geocode was not successful for the following reason: " + e);
                    });
            }


        </script>
    @endpush
</x-base-layout>

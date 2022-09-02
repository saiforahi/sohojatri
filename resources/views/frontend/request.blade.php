@extends('frontend.layout.app')
@section('content')

<style>
    /* placeholder color */
    ::-webkit-input-placeholder { /* Edge */
      color: black;
      }
      .input-group > .form-control::placeholder {
          color: black;
          opacity: 1;
      }
      ::placeholder {
          color: black;
          opacity: 1;
      }
</style>

    <hr class="mt-0">
    <section class="mb-5">
        <div class="container">
            <div class="row mt-3">
                <div class="text-center w-100">
                    <h3 class="text-black Helvetica-Bold mt-10">Post a Request. <span class="a176d9d">Get Alerts.</span></h3>
                    <div class="w-100">
                        <h5 class="mb-2" style="line-height: 25px; font-size: 15px;">
                            Post your request and get notify via sms and email.<br>
                            Post your information for Riders to see. Try it out!
                        </h5>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-12 col-lg-6 mt-5 mt-lg-0">
                    <div class="card rounded mb-3">
                        <div class="card-header py-2 bg-white text-black">
                            <h4 class="my-0">Request for a Ride</h4>
                        </div>
                        <div class="card-body px-5 f1f1f1">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{$error}}
                                    </div>
                                @endforeach
                            @endif
                            @if(session()->has('message'))
                                <div class="alert alert-success alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <form method="post" id="upload_form" action="{{route('request.ride.post')}}"
                                  autocomplete="off">
                                {{csrf_field()}}
                                <div class="input-group mb-3 px-0 input-group-seamless">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-circle-o"
                                                                                        aria-hidden="true"></i></span>
                                    </div>
                                    <input id="start" type="text" class="form-control form-control-sm"
                                           placeholder="Leaving from...">
                                    <input type="hidden" name="lat" id="lat">
                                    <input type="hidden" name="lng" id="lng">
                                    <input type="hidden" name="location" id="location">

                                </div>
                                <div class="input-group mb-3 px-0 input-group-seamless">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-circle-o"
                                                                                        aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" id="end" class="form-control form-control-sm"
                                           placeholder="Going to...">
                                    <input type="hidden" name="lat2" id="lat2">
                                    <input type="hidden" name="lng2" id="lng2">
                                    <input type="hidden" name="location2" id="location2">
                                </div>

                                <div class="row22">
                                    <div class="input-group input-group-sm mb-3 col-6 px-0 pr-1 input-group-seamless">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"
                                                                                            aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" id="after" name="after" class="form-control datepicker"
                                               placeholder="Journey Date">
                                    </div>
                                    <label class="text-black">Number of seats</label>
                                    <div class="input-group input-group-sm mb-3 col-6 px-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-car"
                                                                                        aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control seat" name="seat" min="1" value="1"
                                               placeholder="1+ seats" value="@if(isset($seat)) {{$seat}} @endif">
                                        <div class="input-group-append">
                                            <span class="input-group-text plus" id="basic-addon1"><i
                                                        class="fas fa-plus"></i></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text minus" id="basic-addon1"><i
                                                        class="fas fa-minus"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mx-auto">
                                    <button type="submit" class="btn btn-sm btn-success">Submit Request</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
                <div class="col-12 col-lg-6">
                    <div class="card p-3 fbf7f7">
                        My ride summary
                        <div id="map" style="width: 100%; height: 500px;">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var directionsService;
        var directionsDisplay;
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 23.777, lng: 90.399
                },
                zoom: 6.5
            });
            
            directionsService = new google.maps.DirectionsService;
            directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(map);
        
            var input = (document.getElementById('start'));
            var input2 = (document.getElementById('end'));


            var autocomplete = new google.maps.places.Autocomplete(input);
            var autocomplete2 = new google.maps.places.Autocomplete(input2);
            autocomplete.bindTo('bounds', map);
            autocomplete2.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();

                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setIcon(/** @type {google.maps.Icon} */({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                var item_Lat = place.geometry.location.lat()
                var item_Lng = place.geometry.location.lng()
                var item_Location = place.formatted_address;
                //alert("Lat= " + item_Lat + "_____Lang=" + item_Lng + "_____Location=" + item_Location);
                $("#lat").val(item_Lat);
                $("#lng").val(item_Lng);
                $("#location").val($('#start').val());


                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                // infowindowContent.children['place-icon'].src = place.icon;
                // infowindowContent.children['place-name'].textContent = place.name;
                // infowindowContent.children['place-address'].textContent = address;
                // infowindow.open(map, marker);
                preparePath();
            });

            autocomplete2.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete2.getPlace();

                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setIcon(/** @type {google.maps.Icon} */({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                var item_Lat = place.geometry.location.lat()
                var item_Lng = place.geometry.location.lng()
                var item_Location = place.formatted_address;
                //alert("Lat= " + item_Lat + "_____Lang=" + item_Lng + "_____Location=" + item_Location);
                $("#lat2").val(item_Lat);
                $("#lng2").val(item_Lng);
                $("#location2").val($('#end').val());


                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                // infowindowContent.children['place-icon'].src = place.icon;
                // infowindowContent.children['place-name'].textContent = place.name;
                // infowindowContent.children['place-address'].textContent = address;
                // infowindow.open(map, marker);
                preparePath();
            });

            // Sets a listener on a radio button to change the filter type on Places
            // Autocomplete.
            function setupClickListener(id, types) {
                var radioButton = document.getElementById(id);
                radioButton.addEventListener('click', function () {
                    autocomplete.setTypes(types);
                });
            }

            setupClickListener('changetype-all', []);
            setupClickListener('changetype-address', ['address']);
            setupClickListener('changetype-establishment', ['establishment']);
            setupClickListener('changetype-geocode', ['geocode']);

            document.getElementById('use-strict-bounds')
                .addEventListener('click', function () {
                    console.log('Checkbox clicked! New state=' + this.checked);
                    autocomplete.setOptions({strictBounds: this.checked});
                });
        }
        
         function preparePath(){
            waypoints = Array();
            var start = $("#start").val();
            var end = $("#end").val();
            if(!start && start =='') return;
            if(!end && end =='') return;
            
            drawPath(directionsService, directionsDisplay,start,end);
        }
        function drawPath(directionsService, directionsDisplay,start,end) {
                directionsService.route({
                 origin: start,
                  destination: end,
                  waypoints: waypoints,
                  optimizeWaypoints: true,
                  travelMode: 'DRIVING'
                }, function(response, status) {
                    if (status === 'OK') {
                        directionsDisplay.setDirections(response);
                    } else {
                    window.alert('Problem in showing direction due to ' + status);
                    }
                });
          }
        
        $(document).ready(function () {
            $('#upload_form').on('submit', function () {
                if ($('#start').val() == "" || $('#end').val() == "" || $('#after').val() == "") {
                    swal({
                        title: "You are not Submit Form",
                        text: "Departure, Destination and Date must be fill-up.",
                        type: "warning",
                    });
                } else {
                    // if ($('#start').val().split(",").length <= 2)
                    //     swal('Error', 'Departure address must be specific address', 'warning'), $('#start').val('');
                    // else if ($('#end').val().split(",").length <= 2)
                    //     swal('Error', 'Destination address must be specific address', 'warning'), $('#end').val('');
                    // else
                        return;
                }
                event.preventDefault();
            });
            preparePath();

        });

        $(function () {
            $(".plus").click(function (e) {
                e.preventDefault();
                var $this = $(this);
                var $input = $(".seat");
                var value = parseInt($input.val());

                if (value < 12) {
                    value = value + 1;
                } else {
                    value = 1;
                }

                $input.val(value);
            });

            $(".minus").click(function (e) {
                e.preventDefault();
                var $this = $(this);
                var $input = $(".seat");
                var value = parseInt($input.val());

                if (value > 1) {
                    value = value - 1;
                } else {
                    value = 1;
                }

                $input.val(value);
            });
        });
    </script>







@endsection
@extends('backend.layout.app')

@section('content')

    <div class="content">

        <h3 class="my-1">Popular Ride</h3>
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
        <div class="card collapse multi-collapse show" id="multiCollapseExample1">
            <div class="card-header">
                <button class="btn btn-sm btn-primary pull-right"
                        data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false"
                        aria-controls="multiCollapseExample1 multiCollapseExample2">Add New Popular Ride
                </button>
            </div>
            <div class="card-body">
                <table class="table border">
                    <thead>
                    <tr>
                        <th scope="col">Departure</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Payment</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ride as $rides)
                        <tr>
                            <td>{{$rides->s_location}}</td>
                            <td>{{$rides->e_location}}</td>
                            <td>{{$rides->payment}}</td>
                            <td>
                                <a href="{{route('admin.popular.ride.delete',$rides->id)}}"
                                   class="btn btn-sm btn-danger delete">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card collapse multi-collapse" id="multiCollapseExample2">
            <div class="card-header">
                <button class="btn btn-sm btn-primary pull-right"
                        data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false"
                        aria-controls="multiCollapseExample1 multiCollapseExample2">View Popular Ride
                </button>
            </div>
            <div class="card-body">
                <form id="upload_form" method="post" action="{{route('admin.popular.ride')}}">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Departure</label>
                        <div class="col-sm-10">
                            <input id="start" type="text" class="form-control shadow-none"
                                   placeholder="Departure"
                                   value="@if(isset($userLoca)) {{$userLoca}} @endif">
                            <input type="hidden" name="lat" id="lat"
                                   value="@if(isset($userLat)) {{$userLat}} @endif">
                            <input type="hidden" name="lng" id="lng"
                                   value="@if(isset($userLng)) {{$userLng}} @endif">
                            <input type="hidden" name="location" id="location"
                                   value="@if(isset($userLoca)) {{$userLoca}} @endif">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Destination</label>
                        <div class="col-sm-10">
                            <input type="text" id="end" class="form-control shadow-none"
                                   placeholder="Destination"
                                   value="@if(isset($userLoca2)) {{$userLoca2}} @endif">
                            <input type="hidden" name="lat2" id="lat2"
                                   value="@if(isset($userLat2)) {{$userLat2}} @endif">
                            <input type="hidden" name="lng2" id="lng2"
                                   value="@if(isset($userLng2)) {{$userLng2}} @endif">
                            <input type="hidden" name="location2" id="location2"
                                   value="@if(isset($userLoca2)) {{$userLoca2}} @endif">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Payment</label>
                        <div class="col-sm-10">
                            <input id="after" type="Number" name="payment" class="form-control"
                                   placeholder="Payment">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">
                        Save
                    </button>
                </form>
            </div>
        </div>

    </div>
    <div id="map">

    </div>
    <script>

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 23.777, lng: 90.399
                },
                zoom: 6.5
            });
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
                $("#location").val(item_Location);


                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindowContent.children['place-icon'].src = place.icon;
                infowindowContent.children['place-name'].textContent = place.name;
                infowindowContent.children['place-address'].textContent = address;
                infowindow.open(map, marker);
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
                $("#location2").val(item_Location);


                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindowContent.children['place-icon'].src = place.icon;
                infowindowContent.children['place-name'].textContent = place.name;
                infowindowContent.children['place-address'].textContent = address;
                infowindow.open(map, marker);
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

        $(document).ready(function () {
            $('#upload_form').on('submit', function () {
                if ($('#start').val() == "" || $('#end').val() == "" || $('#after').val() == "") {
                    event.preventDefault();
                }
                console.log($('#start').val().split(",").length)

                if ($('#start').val().split(",").length > 2) {
                    event.preventDefault();
                    swal('Error', 'Departure address must be district name', 'warning'), $('#start').val('');
                } else if ($('#end').val().split(",").length > 2) {
                    event.preventDefault();
                    swal('Error', 'Destination address must be district name', 'warning'), $('#end').val('');
                }
            });

        });
    </script>


@endsection


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Durpalla</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="http://durpalla.xyz/css/bootstrap.css">
    <link rel="stylesheet" href="http://durpalla.xyz/css/util.css">
    <link rel="stylesheet" href="http://durpalla.xyz/vendors/linericon/style.css">
    <link rel="stylesheet" href="http://durpalla.xyz/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://durpalla.xyz/css/magnific-popup.css">
    <link rel="stylesheet" href="http://durpalla.xyz/vendors/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="http://durpalla.xyz/vendors/lightbox/simpleLightbox.css">
    <link rel="stylesheet" href="http://durpalla.xyz/vendors/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="http://durpalla.xyz/vendors/animate-css/animate.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://unpkg.com/shards-ui@latest/dist/css/shards.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="http://durpalla.xyz/css/style.css">
    <link rel="stylesheet" href="http://durpalla.xyz/custom/frontend/mainIndex.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/v4-shims.css">
    <script src="http://durpalla.xyz/js/jquery-3.2.1.min.js"></script>
</head>
<body>


<!--================ Start Header Menu Area =================-->
<style>
    .header_area {
        z-index: 1040 !important;
    }
</style>
<header class="header_area border-bottom fbf7f7">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="http://durpalla.xyz"><img src="http://durpalla.xyz/img/logo/logo.png" alt="durpalla logo"></a>
                <button class="navbar-toggler mr-2" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto Helvetica">
                        <li class="nav-item mr-lg-3 mr-xl-4 my-1 ml-1 my-lg-0"><a href="http://durpalla.xyz/find-ride"
                                                                                  style="color: #163659;">
                                <i class="fas fa-search"></i> Find a Ride
                            </a></li>
                        <li class="nav-item mr-lg-3 mr-xl-4 my-1 ml-1 my-lg-0"><a href="http://durpalla.xyz/post-ride"
                                                                                  style="color: #163659;">
                                <i class="fas fa-plus-circle"></i> Post a Ride
                            </a></li>
                        <li class="nav-item mr-lg-3 mr-xl-4 my-1 ml-1 my-lg-0"><a href="http://durpalla.xyz/request"
                                                                                  style="color: #163659;">
                                <i class="fas fa-hand-point-up"></i> Request a Ride
                            </a></li>
                        <li class="nav-item mr-lg-3 mr-xl-4 my-1 ml-1 my-lg-0"><a href="http://durpalla.xyz/all-ride"
                                                                                  style="color: #163659;">
                                <i class="fas fa-align-right"></i> All Rides
                            </a></li>
                    </ul>
                    <ul class="nav navbar-nav ml-auto">
                        <div class="social-icons d-flex align-items-center">
                            <a href="">
                                <li>

                                                                            <a href="http://durpalla.xyz/language?lng=bn"
                                           style="color: #163659!important;">বাংলা</a>
                                                                    </li>
                            </a>
                                                            <a href="http://durpalla.xyz/registration" class="genric-btn info-border radius"
                                   style="line-height: 2;padding: 0 15px;color: #163659!important;">
                                    <li>Sign up</li>
                                </a>
                                <a href="http://durpalla.xyz/login" class="genric-btn info-border radius"
                                   style="line-height: 2;padding: 0 15px;margin-left: 14px;color: #163659!important;">
                                    <li>Log in</li>
                                </a>

                                                    </div>
                                            </ul>
                </div>
            </div>
        </nav>
    </div>
</header>


<script>

    $(window).on('load', function () {
        $('#myModal').modal('show');
    });

    $(document).on('click', '.notishow', function () {
        $.ajax({
            url: "http://durpalla.xyz/notification-show",
            type: 'get',
            success: function (response) {
                $('.notify-badge').hide();
            }
        });
    });

</script>


<!--================ End Header Menu Area =================-->

    <style>
        .news-feed-container {
            float: none;
            clear: none;
            width: 100%;
            height: auto;
            font-size: 12px;
            overflow: hidden;
            border-top: 0;
            border-bottom: 0;
        }

        div.relative {
            position: relative;
            width: 28px;
            height: 70px;
            border: 0;
        }

        div.absolute {
            position: absolute;
            top: 10px;
            left: 5px;
            padding: 4px;
            border-radius: 10px;
            border: 2px solid #73AD21;
        }

        div.absolute2 {
            position: absolute;
            top: 20px;
            left: 10px;
            height: 54px;
            border: 1px solid #73AD21;
        }

        div.absolute3 {
            position: absolute;
            top: 72px;
            left: 5px;
            padding: 4px;
            border-radius: 10px;
            border: 2px solid #73AD21;
        }
    </style>


    <hr class="mt-0">
    <section class="mb-5 overlay222">
        <div class="container">
            <div class="row mt-3">
                <div class="text-center w-100">
                    <h3 class="text-black Helvetica-Bold">Find a Ride</h3>
                    <div class="w-100 fff611 p-2">
                        <p class="mb-0">Get to your exact destination, without the hassle. No queues. No waiting around.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-12 col-lg-6 mt-5 mt-lg-0">
                    <form id="upload_form" method="post" action="http://durpalla.xyz/find-ride">
                        <div class="card rounded mb-3">
                            <div class="card-header py-1 bg-white text-black fs-15">
                                Looing for a ride?
                            </div>
                            <div class="card-body px-2 f1f1f1">
                                                                                                <div class="input-group mb-3 px-0 input-group-seamless">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-circle-o"
                                                                                        aria-hidden="true"></i></span>
                                    </div>
                                    <input id="start" type="text" class="form-control"
                                           placeholder="Departure point (address, City Station)"
                                           value="">
                                    <input type="hidden" name="lat" id="lat"
                                           value="">
                                    <input type="hidden" name="lng" id="lng"
                                           value="">
                                    <input type="hidden" name="location" id="location"
                                           value="">

                                </div>
                                <div class="input-group mb-3 px-0 input-group-seamless">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-circle-o"
                                                                                        aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" id="end" class="form-control"
                                           placeholder="Arrival point (address, City Station)"
                                           value="">
                                    <input type="hidden" name="lat2" id="lat2"
                                           value="">
                                    <input type="hidden" name="lng2" id="lng2"
                                           value="">
                                    <input type="hidden" name="location2" id="location2"
                                           value="">
                                </div>

                            </div>
                        </div>

                        <div class="card rounded mb-3">
                            <div class="card-header bg-white text-black fs-15 py-1">
                                Date and Time
                            </div>
                            <div class="card-body px-2 f1f1f1">

                                <div class="row mx-1">
                                    <div class="mb-3 col-12 px-0 pr-1">
                                        <div class="row">
                                            <div class="col-4">
                                                Travel Date:
                                            </div>
                                            <div class="col-8">
                                                <div class="input-group input-group-sm input-group-seamless">
                                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"
                                                                                            aria-hidden="true"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datepicker" id="after"
                                                           name="after"
                                                           value=""
                                                           placeholder="On or After">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12 px-0 pr-1">
                                        <div class="row">
                                            <div class="col-4">
                                                Travel Date:
                                            </div>
                                            <div class="col-8">
                                                <div class="input-group input-group-sm input-group-seamless">
                                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"
                                                                                            aria-hidden="true"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datepicker" id="before"
                                                           name="before"
                                                           value=""
                                                           placeholder="On or Before">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="mb-3 col-12 px-0">
                                        <div class="row">
                                            <div class="col-4">
                                                Number of Seats:
                                            </div>
                                            <div class="col-8">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-car"
                                                                                        aria-hidden="true"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control seat" name="seat" min="1"
                                                           value="1"
                                                           placeholder="1+ seats"
                                                           value="">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mx-auto">
                                <button class="btn efeb42"><img src="http://durpalla.xyz/PNG/Layer 23.png" style="width: 18px;
    margin: 0 9px 0 0;">Find a ride
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card p-3 fbf7f7">
                        <div id="map" style="width: 100%; height: 500px;">

                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </section>


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
                marker.setIcon(/** @type  {google.maps.Icon} */({
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
                marker.setIcon(/** @type  {google.maps.Icon} */({
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
                    swal({
                        title: "You are not Submit Form",
                        text: "Departure, Destination and Date must be fill-up.",
                        type: "warning",
                    });
                } else {
                    if ($('#start').val().split(",").length <= 2)
                        swal('Error', 'Departure address must be specific address', 'warning'), $('#start').val('');
                    else if ($('#end').val().split(",").length <= 2)
                        swal('Error', 'Destination address must be specific address', 'warning'), $('#end').val('');
                    else
                        return;
                }
                event.preventDefault();
            });

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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMfl6pAmNv3T6PoDRy7ESSJRZLLSFf2jI&libraries=places&callback=initMap"
            async defer></script>


<!--================  start footer Area =================-->
<style>
    .footer_top {
        background-color: #ffffff;
        width: 100%;
        background-repeat: no-repeat;
        background-size: cover;
        color: black !important;
    }

    .footer_top .backgroundWhite {
        width: 100%;
        height: 100%;
        padding: 50px 0 34px 0;
    }
    .footer_top a{color: rgb(119,119,119);}
</style>

<footer class="footer-area border-top fbf7f7">
    <div class="footer_top section_gap_top py-0 fbf7f7">
        <div class="backgroundWhite">
            <div class="container">
                <div class="row fs-12">
                    <div class="col-12 col-md-6 col-lg">
                        <ul class="list-unstyled">
                            <li><h6>Passenger</h6></li>
                            <li><a href="#">Search Rides</a></li>
                            <li><a href="#">Create Account</a></li>
                            <li><a href="#">My Bookings</a></li>
                            <li><a href="#">Buy Booking Credits</a></li>
                            <li><a href="#">How Does it Work?</a></li>
                            <li><a href="#">Notifications</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 col-lg">
                        <ul class="list-unstyled">
                            <li><h6>Driver</h6></li>
                            <li><a href="#">Post a Ride</a></li>
                            <li><a href="#">Create Account</a></li>
                            <li><a href="#">My Cars</a></li>
                            <li><a href="#">Who Are My Passengers?</a></li>
                            <li><a href="#">Earnings</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 col-lg">
                        <ul class="list-unstyled">
                            <li><h6>My Account</h6></li>
                            <li><a href="#">Sign in</a></li>
                            <li><a href="#">My Profile</a></li>
                            <li><a href="#">Contact Info</a></li>
                            <li><a href="#">Preferences</a></li>
                            <li><a href="#">Ride History</a></li>
                            <li><a href="#">Transactions</a></li>
                            <li><a href="#">My Offers</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 col-lg">
                        <ul class="list-unstyled">
                            <li><h6>About Us</h6></li>
                            <li><a href="#">Who are we?</a></li>
                            <li><a href="#">Contact us</a></li>
                            <li><a href="#">Career</a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><h6>Help Center</h6></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Policies</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 col-lg">
                        <ul class="list-unstyled">
                            <li><h6>Newsletter</h6></li>
                            <li>
                                <form class="form">
                                    <input type="email" class="form__field" placeholder="your email..." />
                                    <button type="button" class="btn22 btn--primary btn--inside uppercase">Send</button>
                                </form>
                                <br>
                            </li>
                        </ul>
                        <ul class="list-unstyled mt-10">
                            <li><h6>Connect with Us</h6></li>
                            <li>
                                <div class="social-icons fs-19">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-dribbble"></i></a>
                                    <a href="#"><i class="fa fa-behance"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        All rights reserved by <a class="text-success" href="#">durpalla.com</a>
                </div>
                <div class="col-lg-6 col-md-12 text-right">
                    Teams of use provicy | Security Statement
                </div>
            </div>
        </div>
    </div>
</footer>
<!--================ End footer Area =================-->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="http://durpalla.xyz/js/popper.js"></script>
<script src="http://durpalla.xyz/js/bootstrap.min.js"></script>
<script src="http://durpalla.xyz/js/stellar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="http://durpalla.xyz/js/jquery.magnific-popup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="http://durpalla.xyz/vendors/lightbox/simpleLightbox.min.js"></script>
<script src="http://durpalla.xyz/vendors/nice-select/js/jquery.nice-select.min.js"></script>
<script src="http://durpalla.xyz/vendors/owl-carousel/owl.carousel.min.js"></script>
<script src="http://durpalla.xyz/js/jquery.ajaxchimp.min.js"></script>
<script src="http://durpalla.xyz/vendors/counter-up/jquery.waypoints.min.js"></script>
<script src="http://durpalla.xyz/vendors/counter-up/jquery.counterup.js"></script>
<script src="http://durpalla.xyz/js/mail-script.js"></script>
<script src="http://durpalla.xyz/js/script.js"></script>
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<!--gmaps Js-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMfl6pAmNv3T6PoDRy7ESSJRZLLSFf2jI&libraries=places&callback=initMap"
        async defer></script>
<script src="http://durpalla.xyz/js/theme.js"></script>
</body>

</html>
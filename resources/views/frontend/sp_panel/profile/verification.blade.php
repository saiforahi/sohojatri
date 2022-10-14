@extends('frontend.sp_panel.profile.layout.app')

@section('content')
    <style type="text/css" media="screen">
        .verify {
            background: #00AFF5 !important;
            background-image: initial !important;
            background-position-x: initial !important;
            background-position-y: initial !important;
            background-size: initial !important;
            background-repeat-x: initial !important;
            background-repeat-y: initial !important;
            background-attachment: initial !important;
            background-origin: initial !important;
            background-clip: initial !important;
            background-color: rgb(0, 175, 245) !important;
            display: inline-block;
            box-sizing: border-box;
            height: 36px;
            padding: 10px 15px;
            border: 0;
            border-radius: 3px;
            color: #fff;
            font-family: gt-eesti, Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 16px;
            text-align: center;
            text-decoration: none;
            box-shadow: inset 0 -2px rgba(5, 71, 82, 0.2);
            cursor: pointer
        }

        .verifiedmassage {
            font-size: 16px;
            font-weight: bold;
            color: #054752;
        }

        .img-size-verified {
            width: 45px;
        }

        .verify-heading {
            font-family: gt-eesti, "Helvetica Neue", Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 13px;
            line-height: 18px;
            -webkit-backface-visibility: hidden;
            color: #054752;
        }

        .inline-verified-massage {
            color: #252a2b;
            font-size: 14px;
            line-height: 20px;
        }

        .hrstyle {
            width: 76%;
            margin-left: 1px;
        }

        .border-all {
            border: 1px solid #c0bfce;
        }

        .box-card {
            height: 107px;
        }

        .box-card1 {
            height: 107px;
        }
    </style>
    <div class="content" style="background-color: white">
        <h3>Verification</h3>
        <hr class="">
        <p class="verify-heading">Verify your profile to become a trusted member of our community and easily find others
            to travel with!</p>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                    <span class="badge badge-pill badge-danger">Error</span>
                    {{$error}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endforeach
        @endif
        @if(session()->has('message'))
            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Alert</span>
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        <div class="card" style="width: 76%;">
            <div class="card-body border-all">
                <div class="accordion" id="accordionExample">
                    <div class="card ">
                        <div class="card-header verifiedmassage border-all "
                             id="headingOne">@if(!isset($verification->nid))<i class="fas fa-exclamation-circle"
                                                                               style="color:orange"></i>  Please verify
                            your NID Number:
                            <p> Other members will be more likely to choose to travel with you!</p>
                            @endif
                            @if($verification->nid_status==0 && isset($verification->nid))
                                <p class="inline-verified-massage verify-heading"> Your NID is: {{$verification->nid}}
                                    <br>
                                    we can easily contact you if needed.</p>@endif
                            @if($verification->nid_status==1)
                                NID verified <br> <p class="inline-verified-massage verify-heading"> Your NID
                                    is: {{$verification->nid}} <br>
                                    we can easily contact you if needed.</p>@endif
                        <!--  @if($verification->nid_image1)<img src="{{asset('/'.$verification->nid_image1)}}" class="img-thumbnail  img-size-verified">@endif
                            @if($verification->nid_image2)<img src="{{asset('/'.$verification->nid_image2)}}" class="img-thumbnail img-size-verified">@endif -->
                            @if(!isset($verification->nid))
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    style="padding: 12px 28px 11px 36px;" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Verify
                                </button>@endif
                            @if(isset($verification->nid_image1)&&($verification->nid_status==0))
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    style="padding: 12px 28px 11px 36px;" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Edit
                                </button>@endif
                            @if(isset($verification->nid_image1)&&($verification->nid_status==2))
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    style="padding: 12px 28px 11px 36px;" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Update
                                </button>@endif
                            @if($verification->nid == "")
                                <span class="badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                      style="display:none">Please Enter</span>
                            @elseif($verification->nid_status == 0)
                                <span class="badge badge-pill badge-danger pull-right m-1 mr-5 verify">Pending..</span>
                            @elseif($verification->nid_status == 2)
                                <span
                                    class="badge badge-pill badge-danger pull-right m-1 mr-5 verify">Not Verified</span>
                            @else
                                <span id="hh" class="badge badge-pill pull-right m-1 mr-5   " data-toggle="tooltip"
                                      data-placement="top" title="Your NID is Verified"> <i class="fa fa-check-circle"
                                                                                            aria-hidden="true"
                                                                                            style="    font-size: 32px; color: #35aff5"></i></span>

                            @endif

                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <form action="{{route('sp.verification')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-row align-items-center">
                                        <div class="col-4">
                                            <label for="inputPassword2" class="sr-only">Password</label>
                                            <input type="number" name="nid" class="form-control" id="inputPassword2"
                                                   placeholder="Enter your nid number">
                                        </div>
                                        <div class="col-4">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input w-25" name="nidImage1"
                                                       id="inputGroupFile01"
                                                       aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" id="nidfastpage"
                                                       for="inputGroupFile01">NID First Page</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input w-25" name="nidImage2"
                                                       id="inputGroupFile02"
                                                       aria-describedby="inputGroupFileAddon02">
                                                <label class="custom-file-label" id="nidlastpage"
                                                       for="inputGroupFile02">NID Last Page</label>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-2" style="margin-left: auto;">
                                            <button type="submit" name="submit" value="nid"
                                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify "
                                                    style="padding: 12px 28px 11px 26px;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header verifiedmassage border-all"
                             id="headingTwo">@if(!isset($verification->passport))<i class="fas fa-exclamation-circle"
                                                                                    style="color:orange"></i> Please
                            verify your Passport
                            <p> Other members will be more likely to choose to travel with you!</p>
                            @endif
                            @if($verification->passport_status==0 && isset($verification->passport))
                                <p class="inline-verified-massage verify-heading"> Your Passport
                                    is: {{$verification->passport}} <br>
                                    we can easily contact you if needed.</p>@endif
                            @if($verification->passport_status==1)
                                Passport verified <br> <p class="inline-verified-massage verify-heading"> Your Passport
                                    is: {{$verification->passport}} <br>
                                    Other members will be more likely to choose to travel with you.</p>@endif
                        <!--  @if($verification->passport_image1) <img src="{{asset('/'.$verification->passport_image1)}}" class="img-thumbnail img-size-verified">@endif
                            @if($verification->passport_image2) <img src="{{asset('/'.$verification->passport_image2)}}" class="img-thumbnail img-size-verified">@endif -->
                            @if(!isset($verification->passport))
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    type="button" data-toggle="collapse" style="padding: 12px 28px 11px 36px;"
                                    data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Verify
                                </button>
                            @endif
                            @if(isset($verification->passport_image1)&&($verification->passport_status==0))
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    type="button" data-toggle="collapse" style="padding: 12px 28px 11px 36px;"
                                    data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Edit
                                </button>
                            @endif
                            @if(isset($verification->nid_image1)&&($verification->passport_status==2))
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    style="padding: 12px 28px 11px 36px;" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Update
                                </button>@endif
                            @if($verification->passport == "")
                                <span class="badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                      style="display:none">Please Enter</span>
                            @elseif($verification->passport_status == 0)
                                <span class="badge badge-pill badge-danger pull-right m-1 mr-5 verify">Pending..</span>
                            @elseif($verification->passport_status == 2)
                                <span
                                    class="badge badge-pill badge-danger pull-right m-1 mr-5 verify">Not Verified</span>
                            @else
                                <span class="badge badge-pill  pull-right m-1 mr-5  " data-toggle="tooltip"
                                      data-placement="top" title="Your Passport is Verified"> <i
                                        class="fa fa-check-circle" aria-hidden="true"
                                        style="    font-size: 32px; color: #35aff5"></i></span>
                            @endif
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <form action="{{route('sp.verification')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-row align-items-center">
                                        <div class="col-4">
                                            <label for="inputPassword2" class="sr-only">Passport</label>
                                            <input type="text" name="passport" class="form-control" id="inputPassword2"
                                                   placeholder="Enter your Passport number">
                                        </div>
                                        <div class="col-4">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input w-25" name="passportImage1"
                                                       id="inputGroupFile03"
                                                       aria-describedby="inputGroupFileAddon03">
                                                <label class="custom-file-label" id="passportfastpage"
                                                       for="inputGroupFile03">Passport first page</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-2">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input w-25" name="passportImage2"
                                                       id="inputGroupFile04"
                                                       aria-describedby="inputGroupFileAddon04">
                                                <label class="custom-file-label" id="passportlastpage"
                                                       for="inputGroupFile04">Passport last page</label>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-2" style="margin-left: auto;">
                                            <button type="submit" name="submit" value="passport"
                                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify "
                                                    style="padding: 12px 28px 11px 26px;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header verifiedmassage border-all" id="headingThree">
                            @if(!isset($verification->driving))<i class="fas fa-exclamation-circle"
                                                                  style="color:orange"></i> Please verify your Driving
                            Licence
                            <p> Other members will be more likely to choose to travel with you!</p>
                            @endif
                            @if($verification->driving_status==0 && isset($verification->passport))
                                <p class="inline-verified-massage verify-heading"> Your Driving
                                    is: {{$verification->driving}} <br>
                                    we can easily contact you if needed.</p>@endif
                            @if($verification->driving_status==1)
                                Driving verified <br> <p class="inline-verified-massage verify-heading"> Your Driving
                                    is: {{$verification->driving}} <br>
                                    Other members will be more likely to choose to travel with you.</p>@endif




                        <!-- @if($verification->driving_image1) <img src="{{asset('/'.$verification->driving_image1)}}" class="img-thumbnail img-size-verified">@endif
                            @if($verification->driving_image2) <img src="{{asset('/'.$verification->driving_image2)}}" class="img-thumbnail img-size-verified">@endif -->
                            @if(!isset($verification->driving))
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    type="button" data-toggle="collapse" style="padding: 12px 28px 11px 36px;"
                                    data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    Verify
                                </button>
                            @endif
                            @if(isset($verification->driving_image1)&&($verification->driving_status==0))
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    type="button" data-toggle="collapse" style="padding: 12px 28px 11px 36px;"
                                    data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    Edit
                                </button>
                            @endif
                            @if(isset($verification->nid_image1)&&($verification->passport_status==2))
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    style="padding: 12px 28px 11px 36px;" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Update
                                </button>@endif
                            @if($verification->driving == "")
                                <span class="badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                      style="display:none">Please Enter</span>
                            @elseif($verification->driving_status == 0)
                                <span class="badge badge-pill badge-danger pull-right m-1 mr-5 verify">Pending..</span>
                            @elseif($verification->driving_status == 2)
                                <span
                                    class="badge badge-pill badge-danger pull-right m-1 mr-5 verify">Not Verified</span>
                            @else
                                <span class="badge badge-pill  pull-right m-1 mr-5  " data-toggle="tooltip"
                                      data-placement="top" title="Your Driving is Verified"> <i
                                        class="fa fa-check-circle" aria-hidden="true"
                                        style="    font-size: 32px; color: #35aff5"></i></span>
                            @endif
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <form action="{{route('sp.verification')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-row align-items-center">
                                        <div class="col-4">
                                            <label for="inputPassword2" class="sr-only">Passport</label>
                                            <input type="text" name="driving" class="form-control" id="inputPassword2"
                                                   placeholder="Enter your Driving Licence">
                                        </div>
                                        <div class="col-4">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input w-25" name="drivingImage1"
                                                       id="inputGroupFile05"
                                                       aria-describedby="inputGroupFileAddon05">
                                                <label class="custom-file-label" id="drivingfastpage"
                                                       for="inputGroupFile05">Driving First Page</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-2">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input w-25" name="drivingImage2"
                                                       id="inputGroupFile06"
                                                       aria-describedby="inputGroupFileAddon06">
                                                <label class="custom-file-label" id="drivinglastpage"
                                                       for="inputGroupFile06">Driving Last Page</label>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-2" style="margin-left: auto;">
                                            <button type="submit" name="submit" value="driving"
                                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify "
                                                    style="padding: 12px 28px 11px 26px;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header verifiedmassage border-all" id="headingThree">
                            @if($user->email_verified_at == null)<i class="fas fa-exclamation-circle"
                                                               style="color:orange"></i> Please verify your Email
                            <p> Other members will be more likely to choose to travel with you!</p>
                            @endif

                            @if($user->email_verified_at != null)
                                Email verified <br> <p class="inline-verified-massage verify-heading"> Your Email is:
                                    <strong> {{$user->email}} </strong><br>
                                    Now that you've verified your email address, we can easily contact you if needed.
                                </p>@endif



                        <!--   <i class="fas fa-exclamation-circle" style="color:orange"></i>
                                                     Please Verify Your Email Id: {{$verification->email}}<br>
                           <p> Other members will be more likely to choose to travel with you!</p> -->
                            @if($user->email_verified_at == null)
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    type="button" data-toggle="collapse" style="padding: 12px 28px 11px 36px;"
                                    data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    Verify
                                </button>
                            @endif
                            @if($user->email_verified_at != null)
                                <span class="badge badge-pill  pull-right m-1 mr-5 " data-toggle="tooltip"
                                      data-placement="top" title="Your Email is Verified"> <i class="fa fa-check-circle"
                                                                                              aria-hidden="true"
                                                                                              style="    font-size: 32px; color: #35aff5"></i></span>
                            @endif
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingThree"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <form action="{{route('sp.verification')}}" method="post" class="form-inline">
                                    {{csrf_field()}}
                                    <div class="form-group mx-sm-3 mb-2 w-50">
                                        <label for="email" class="sr-only">email</label>
                                        <input type="email" name="email" class="form-control w-100" id="email"
                                               value="{{UserEmail($verification->user_id)}}"
                                               placeholder="Enter your email id">
                                    </div>
                                    <button type="submit" name="submit" value="email" class="btn btn-primary mb-2">
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header verifiedmassage border-all" id="headingThree">
                            @if($user->phoneIsVerified == 0)<i class="fas fa-exclamation-circle"
                                                               style="color:orange"></i> Please verify your Phone
                            Number: {{$user->phone}}
                            <p> Add a phone number so you can verify it.
                                Adding your phone number means<br> you'll be able to arrange your rides more easily.</p>
                            @endif

                            @if($user->phoneIsVerified == 1)
                                Phone verified <br> <p class="inline-verified-massage verify-heading"> Your phone
                                    is: {{$user->phone}} <br>
                                    Now that you've verified your Phone number, we can easily contact you if needed.
                                </p>@endif

                            @if($user->phoneIsVerified == 0)
                                <button
                                    class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                    type="button" data-toggle="collapse" style="padding: 12px 28px 11px 36px;"
                                    data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    Verify
                                </button>
                            @endif
                            @if($user->phoneIsVerified == 1)
                                <span class="badge badge-pill  pull-right m-1 mr-5 " data-toggle="tooltip"
                                      data-placement="top" title="Your Phone is Verified"> <i class="fa fa-check-circle"
                                                                                              aria-hidden="true"
                                                                                              style="    font-size: 32px; color: #35aff5"></i></span>
                            @endif
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingThree"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <form action="{{route('sp.verification')}}" method="post" class="form-inline">
                                    {{csrf_field()}}
                                    <div class="form-group mx-sm-3 mb-2 w-50">
                                        <label for="phone" class="sr-only">phone</label>
                                        <input type="text" name="phone" class="form-control w-100"
                                               id="phone"
                                               value="{{UserPhone($verification->user_id)}}"
                                               placeholder="Enter your Phone number">
                                    </div>
                                    <button type="submit" name="submit" value="phone" class="btn btn-primary mb-2">
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header verifiedmassage border-all" id="headingThree">
                            @if(!isset($user->facebook_id))<i class="fas fa-exclamation-circle"
                                                              style="color:orange"></i> Please connect your
                            Facebook account
                            <p> Connect your account so other members can see how many Facebook friends you have, and
                                build trust on your profile.!</p>
                            @endif

                            @if($user->facebook_id)
                                Facebook verified <br> <p class="inline-verified-massage verify-heading">
                                    connect your Facebook account .</p>@endif


                            @if(!isset($user->facebook_id))
                                <a href="{{route('signup.facebook')}}"
                                   class="btn btn-sm pull-right badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                   type="button" style="padding: 12px 4px -2px 36px;"><i
                                        class="fab fa-facebook-f"></i>
                                    Connect
                                </a>
                            @endif
                            @if($user->facebook_id == "")
                                <span class="badge badge-pill badge-warning pull-right m-1 mr-5 verify"
                                      style="display:none">Please Enter</span>
                            @else
                                <span class="badge badge-pill  pull-right m-1 mr-5 " data-toggle="tooltip"
                                      data-placement="top" title="Your Email is Verified"> <i class="fa fa-check-circle"
                                                                                              aria-hidden="true"
                                                                                              style="    font-size: 32px; color: #35aff5"></i></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    $(function () {
        $('.mess').hover(
            function () {
                $(this).append($("<span> *** My NID ***</span>"));
            }, function () {
                $(this).find("span").last().remove();
            }
        );
        $('.passport').hover(
            function () {
                $(this).append($("<span> *** My Passport ***</span>"));
            }, function () {
                $(this).find("span").last().remove();
            }
        );
        $('.driving').hover(
            function () {
                $(this).append($("<span> *** My Driving ***</span>"));
            }, function () {
                $(this).find("span").last().remove();
            }
        );
        $('.email').hover(
            function () {
                $(this).append($("<span> *** My Email ***</span>"));
            }, function () {
                $(this).find("span").last().remove();
            }
        );
        $('.phone').hover(
            function () {
                $(this).append($("<span> *** My Phone ***</span>"));
            }, function () {
                $(this).find("span").last().remove();
            }
        );

        $("#inputGroupFile01").on('change', function () {
            var filepath = $(this).val().split("\\");
            var filename = filepath[filepath.length - 1];
            $('#nidfastpage').text(filename);
        });
        $("#inputGroupFile02").on('change', function () {
            var filepath = $(this).val().split("\\");
            var filename = filepath[filepath.length - 1];
            $('#nidlastpage').text(filename);
        });

        $("#inputGroupFile03").on('change', function () {
            var filepath = $(this).val().split("\\");
            var filename = filepath[filepath.length - 1];
            $('#passportfastpage').text(filename);
        });
        $("#inputGroupFile04").on('change', function () {
            var filepath = $(this).val().split("\\");
            var filename = filepath[filepath.length - 1];
            $('#passportlastpage').text(filename);
        });
        $("#inputGroupFile05").on('change', function () {
            var filepath = $(this).val().split("\\");
            var filename = filepath[filepath.length - 1];
            $('#drivingfastpage').text(filename);
        });
        $("#inputGroupFile06").on('change', function () {
            var filepath = $(this).val().split("\\");
            var filename = filepath[filepath.length - 1];
            $('#drivinglastpage').text(filename);
        });

    });

</script>

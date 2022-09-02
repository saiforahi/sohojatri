@extends('frontend.layout.app')
@section('content')
    <section>
        <div class="container-fluid">


            <div class="row mt-3">

                {{--  <div class="w-100 text-center mb-3 mx-auto">
                     <h2>Offer a ride on your next long journey</h2>
                     <p>After booking you can chat with your Tasker, agree on a exact time.</p>
                 </div> --}}


                <div class="row text-center mb-3 mx-auto">
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
                </div>

            </div>

        </div>
        <div class="container" style="margin-top: 10px;">

            <h4 class="text-center" style="font-size: 16px; font-weight: bolder; margin-bottom: 20px;">Most Popular
                Rides</h4>

            <div class="panel panel-warning panel_whole px-3">
                <h5 class="text-center" style="font-weight: 550; padding-top: 30px;">Where do you want to go ?</h5><br>
                <div class="row">
                    @foreach ($popular as $populars)
                        @php
                            $s_location = explode(",", $populars->s_location);
                            $e_location = explode(",", $populars->e_location);
                        @endphp
                        <div class="col-md-4 mb-3" style="cursor: pointer"
                             onclick="location.href='{{route('all.ride.search', $populars->id)}}'">
                            <div class="well well-sm"><img class="img2" src="{{asset('/postimage/')}}/img2.png"
                                                           alt="">{{$s_location[count($s_location)-2]}}
                                <img class="img0" src="{{asset('/postimage/')}}/img0.png" alt=""><img class="img1"
                                                                                                      src="{{asset('/postimage/')}}/img1.png"
                                                                                                      alt=""> {{$e_location[count($e_location)-2]}}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
        <br><br><br>
    </section>
    <div id="map">

    </div>


@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custome_css/style.css') }}">
@endpush

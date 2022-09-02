@extends('frontend.sp_panel.layout.app')

@section('content')

    <div class="content">

        <div class="container px-md-0">
            <div class="col-12 col-lg-12 mt-3 mx-auto px-0">

                <div class="card mt-3">
                    <div class="card-header bg-paste py-1">
                        Departure time:
                        <i class="fa fa-calendar"
                           aria-hidden="true"></i> {{$post->d_time}} {{$post->d_time2}} {{$post->departure}}
                        @if($post->return != "")
                            Return time:
                            <i class="fa fa-calendar"
                               aria-hidden="true"></i> {{$post->r_time}} {{$post->r_time2}} {{$post->return}}
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row text-uppercase lh-1-1">
                            <div class="col-3">Departure</div>
                            <div class="col-3">Destination</div>
                            <div class="col text-center">kilometers</div>
                            <div class="col text-center">Tracking Id</div>
                            <div class="col text-center">Seat & price</div>
                            <div class="col text-center">Action</div>
                        </div>
                        <hr class="bg-warning">
                        <div class="news-feed-container pb-2">
                            <ul class="list-unstyled">
                                @foreach($stopover as $stopovers)
                                    <?php
                                    $s_location = PostRideAddress($stopovers->post_id, $stopovers->going, 'location');
                                    $e_location = PostRideAddress($stopovers->post_id, $stopovers->target, 'location');
                                    $s_lat = PostRideAddress($stopovers->post_id, $stopovers->going, 'lat');
                                    $s_lng = PostRideAddress($stopovers->post_id, $stopovers->going, 'lng');
                                    $e_lat = PostRideAddress($stopovers->post_id, $stopovers->target, 'lat');
                                    $e_lng = PostRideAddress($stopovers->post_id, $stopovers->target, 'lng');
                                    ?>
                                    <li>
                                        <div class="row text-center">
                                            <div class="col-3 location text-left">
                                                {{$s_location}}
                                            </div>
                                            <div class="col-3 location text-left">
                                                {{$e_location}}
                                            </div>
                                            <div class="col col-md-2 p-0">
                                                <?php echo distance($s_lat, $s_lng, $e_lat, $e_lng, "K") . " Km"; ?>
                                            </div>
                                            <div class="col reviewStar my-auto">
                                                <div class="price">{{$stopovers->tracking}}</div>
                                                @if($request->dit == 5)
                                                    @if($stopovers->status == 0)
                                                        <span class="badge badge-primary">Upcoming Ride</span>
                                                    @elseif($stopovers->status == 1)
                                                        <span class="badge badge-info">Ride Ongoing</span>
                                                    @else
                                                        @if($stopovers->status == 2)
                                                            <span class="badge badge-success">Ride End</span>
                                                            <span class="badge badge-warning">Not Paid</span>
                                                        @elseif($stopovers->status == 4)
                                                            <span class="badge badge-danger">Incomplete Ride</span>
                                                        @else
                                                            <span class="badge badge-success">Complete Ride</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col reviewStar my-auto">
                                                <div class="price my-2 text-bold fs-18 text-black">
                                                    ৳ {{$stopovers->price}}</div>
                                                @if(seat($stopovers->going,$stopovers->target,$stopovers->post_id,$stopovers->date) > 0)
                                                    @for($i=1;$i<=getRide($stopovers->post_id)->seat;$i++)
                                                        @if($i > getRide($stopovers->post_id)->seat - seat($stopovers->going,$stopovers->target,$stopovers->post_id,$stopovers->date))
                                                            <span class="fa-2x fas fa-male"
                                                                  data-toggle="tooltip"
                                                                  data-placement="bottom"></span>
                                                        @else
                                                            <span class="fa-2x fas fa-male text-success"
                                                                  data-toggle="tooltip"
                                                                  data-placement="bottom"></span>
                                                        @endif
                                                    @endfor
                                                @else
                                                    {{"Booked"}}
                                                @endif
                                            </div>
                                            <div class="col reviewStar my-auto">
                                                <a href="{{route('upcoming.ride.book',$stopovers->tracking)}}"
                                                   type="button"
                                                   class="btn btn-sm btn-success">View Book</a>
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

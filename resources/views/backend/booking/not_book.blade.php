@extends('backend.layout.app')

@section('content')

    <div class="content">

        @if(!isset($id))
            <div class="card mt-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8 border-right py-0">
                            <h3 class="my-1">Not Booking Ride</h3>
                        </div>
                        <div class="col">
{{--                            <a href="{{route('admin.not.book','time')}}" class="btn btn-sm btn-primary">Not time--}}
{{--                                over</a>--}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($stopover as $stopovers)
                            <?php
                            $s_location = PostRideAddress($stopovers->post_id, $stopovers->going, 'location');
                            $e_location = PostRideAddress($stopovers->post_id, $stopovers->target, 'location');
                            $s_lat = PostRideAddress($stopovers->post_id, $stopovers->going, 'lat');
                            $s_lng = PostRideAddress($stopovers->post_id, $stopovers->going, 'lng');
                            $e_lat = PostRideAddress($stopovers->post_id, $stopovers->target, 'lat');
                            $e_lng = PostRideAddress($stopovers->post_id, $stopovers->target, 'lng');
                            ?>
                            @if(seat($stopovers->going,$stopovers->target,$stopovers->post_id,$stopovers->date) > 0 && $stopovers->seat < 1)
                                    <div class="col-7 border-right">
                                        Departure: {{$s_location}}<br>
                                        Destination:{{$e_location}}<br>
                                        <i class="far fa-calendar-alt"></i> {{date("l F-d", strtotime($stopovers->date))}}
                                        - {{$stopovers->time}}:{{$stopovers->time2}}<br>
                                        Total Seat: {{getRide($stopovers->post_id)->seat}}<br>
                                        Driver Id: {{getRide($stopovers->post_id)->user_id}}<br>
                                        Driver Name: {{userInformation(getRide($stopovers->post_id)->user_id,'name')}}<br>
                                    </div>
                                    <div class="col-5">
                                        Ride End: {{date("l F-d", strtotime($stopovers->edate))}}
                                        - {{$stopovers->etime}}:{{$stopovers->etime2}}<br>
                                        Seat Book: {{$stopovers->seat}}<br>
                                        Tracking No: {{$stopovers->tracking}}<br>
                                        Trip Id: {{$stopovers->post_id}}<br>
                                        Money Collection: {{$stopovers->price}}<br>
                                        Status:
                                        @if($stopovers->status == 0)
                                            <span class="badge badge-primary">Upcoming Ride</span>
                                        @elseif($stopovers->status == 1)
                                            <span class="badge badge-info">Ride Ongoing</span>
                                        @else
                                            @if($stopovers->status == 2)
                                                <span class="badge badge-success">Ride End</span>
                                            @elseif($stopovers->status == 4)
                                                <span class="badge badge-danger">Incomplete Ride</span>
                                            @else
                                                <span class="badge badge-success">Complete Ride</span>
                                            @endif
                                        @endif
                                        <br>
                                    </div>
                                    <hr class="bg-success w-100">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if(isset($id))
            <div class="card mt-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8 border-right py-0">
                            <h3 class="my-1">Not Booking Ride time not over</h3>
                        </div>
                        <div class="col">
                            <a href="{{route('admin.not.book')}}" class="btn btn-sm btn-primary">Time
                                over</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($stopover as $stopovers)
                            <?php
                            $s_location = PostRideAddress($stopovers->post_id, $stopovers->going, 'location');
                            $e_location = PostRideAddress($stopovers->post_id, $stopovers->target, 'location');
                            $s_lat = PostRideAddress($stopovers->post_id, $stopovers->going, 'lat');
                            $s_lng = PostRideAddress($stopovers->post_id, $stopovers->going, 'lng');
                            $e_lat = PostRideAddress($stopovers->post_id, $stopovers->target, 'lat');
                            $e_lng = PostRideAddress($stopovers->post_id, $stopovers->target, 'lng');
                            ?>
                            @if(seat($stopovers->going,$stopovers->target,$stopovers->post_id,$stopovers->date) > 0 && $stopovers->seat < 1)
                                    <div class="col-7 border-right">
                                        Departure: {{$s_location}}<br>
                                        Destination:{{$e_location}}<br>
                                        <i class="far fa-calendar-alt"></i> {{date("l F-d", strtotime($stopovers->date))}}
                                        - {{$stopovers->time}}:{{$stopovers->time2}}<br>
                                        Total Seat: {{getRide($stopovers->post_id)->seat}}<br>
                                        Driver Id: {{getRide($stopovers->post_id)->user_id}}<br>
                                        Driver Name: {{userInformation(getRide($stopovers->post_id)->user_id,'name')}}<br>
                                    </div>
                                    <div class="col-5">
                                        Ride End: {{date("l F-d", strtotime($stopovers->edate))}}
                                        - {{$stopovers->etime}}:{{$stopovers->etime2}}<br>
                                        Seat Book: {{$stopovers->seat}}<br>
                                        Tracking No: {{$stopovers->tracking}}<br>
                                        Trip Id: {{$stopovers->post_id}}<br>
                                        Money Collection: {{$stopovers->price}}<br>
                                        Status:
                                        @if($stopovers->status == 0)
                                            <span class="badge badge-primary">Upcoming Ride</span>
                                        @elseif($stopovers->status == 1)
                                            <span class="badge badge-info">Ride Ongoing</span>
                                        @else
                                            @if($stopovers->status == 2)
                                                <span class="badge badge-success">Ride End</span>
                                            @elseif($stopovers->status == 4)
                                                <span class="badge badge-danger">Incomplete Ride</span>
                                            @else
                                                <span class="badge badge-success">Complete Ride</span>
                                            @endif
                                        @endif
                                        <br>
                                    </div>
                                    <hr class="bg-success w-100">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection

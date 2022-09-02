@extends('frontend.sp_panel.layout.app')

@section('content')

    <div class="content">

        Here you can find your archived ride post.
        <div class="card mt-2">
            <div class="card-header">
                <div class="row">
                    <div class="col-8 border-right">
                        Booking Information
                    </div>
                    <div class="col">
                        Action
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($post as $posts)
                        <div class="col-8 border-right border-bottom">
                            Departure:{{$posts->s_location}}<br>
                            Destination:{{$posts->e_location}}<br>
                            <i class="far fa-calendar-alt"></i> {{date("l F-d", strtotime($posts->departure))}}
                            - {{$posts->d_time}}:{{$posts->d_time2}}<br>
                            <i class="fas fa-wheelchair"></i> {{$posts->seat}} seat<br>
                            Trip Id:{{$posts->id}}<br>
                        </div>
                        <div class="col-4 pt-2 border-bottom">
                            <a href="{{route('upcoming.ride.preview',$posts->id.'?dit=5')}}" type="button"
                               class="btn btn-sm btn-success">View Ride</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection

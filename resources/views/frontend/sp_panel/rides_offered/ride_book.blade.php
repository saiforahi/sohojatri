@extends('frontend.sp_panel.layout.app')

@section('content')

    <div class="content">

        <div class="container px-md-0">
            <div class="col-12 col-lg-12 mt-3 mx-auto px-0">

                <div class="card mt-3">
                    <div class="card-header bg-paste py-1">
                        Departure time:
                        <i class="fa fa-calendar"
                           aria-hidden="true"></i> {{$stopover->time}} {{$stopover->time2}} {{$stopover->date}}
                    </div>
                    <div class="card-body">
                        <div class="row text-uppercase lh-1-1">
                            <div class="col-4">Passenger Information</div>
                            <div class="col-4">Message</div>
                            <div class="col text-center">Seat</div>
                            <div class="col text-center">Payment</div>
                            <div class="col text-center">Action</div>
                        </div>
                        <hr class="bg-warning">
                        <div class="news-feed-container pb-2">
                            <ul class="list-unstyled">
                                @foreach($book as $books)
                                    <li>
                                        <div class="row text-center">
                                            <div class="col-4 location text-left border-right">
                                                Name: {{UserName($books->user_id)}}<br>
                                                Phone: {{UserPhone($books->user_id)}}<br>
                                                Email: {{UserEmail($books->user_id)}}
                                            </div>
                                            <div class="col-4 location text-left border-right">
                                                {{$books->message}}
                                            </div>
                                            <div class="col border-right">
                                                {{$books->seat}}
                                            </div>
                                            <div class="col border-right">
                                                {{$books->amount}}৳
                                            </div>
                                            <div class="col border-right">
                                                <a href="{{route('booking.preview.index',$books->id)}}" type="button"
                                                   class="btn btn-sm btn-success">View Ride</a>
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

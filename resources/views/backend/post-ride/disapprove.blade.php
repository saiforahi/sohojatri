@extends('backend.layout.app')

@section('content')

<div class="content">


    <div class="card shadow">
        <div class="card-header bg-success text-white">
            All Disapprove Ride
        </div>
        <div class="card-body">
            <table class="table border">
                <thead>
                <tr>
                    <th>Time</th>
                    <th>Ride</th>
                    <th>Driver</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($ride as $rides)
                <tr>
                    <td>
                        <p class="my-0 fs-12 lh-1-2">{{date("l F-d", strtotime($rides->departure))}}</p>
                        <p class="my-0 fs-12 lh-1-2">Time: {{$rides->d_time}} {{$rides->d_time2}}</p>
                        <p class="my-0 fs-12 lh-1-2">Reject: {{date("l F-d. h:i A", strtotime($rides->updated_at))}}</p>
                        
                        <?php $dist = GetDrivingDistance($rides->s_lat, $rides->s_lng, $rides->e_lat, $rides->e_lng); ?>
                        <p class="my-0 fs-12 lh-1-2">Distance: {{$dist['distance']}}</p>
                        <p class="my-0 fs-12 lh-1-2">Duration: {{$dist['time']}}</p>
                        <p class="my-0 fs-12 lh-1-2">Trip Id: {{$rides->id}}</p>
                        <p class="my-0 fs-12 lh-1-2">Total Seat: {{$rides->seat}}</p>
                        <p class="my-0 fs-12 lh-1-2">Car model: {{getCarById($rides->car_id, 'model')}}</p>
                        <p class="my-0 fs-12 lh-1-2">Car number plate: {{getCarById($rides->car_id, 'number_plate')}}</p>
                        <p class="my-0 fs-12 lh-1-2">Car type: {{getCarById($rides->car_id, 'car_type')}}</p>
                    </td>
                    <td>
                        <h6>Departure</h6>
                        <p class="fs-12 lh-1-2">{{$rides->s_location}}</p>
                        <h6>Destination</h6>
                        <p class="fs-12 lh-1-2">{{$rides->e_location}}</p>
                    </td>
                    <td>
                        <aside class="single_sidebar_widget author_widget text-center lh-1-1">
                            <img class="author_img rounded-circle"
                                 width="60px" height="60px"
                                 src="{{userInformation($rides->user_id,'image')}}"
                                 alt=""><br>
                            <h5 class="my-0">{{userInformation($rides->user_id,'name')}}</h5>
                            <p class="fs-8 my-0">
                                @for($i=1;$i<=5;$i++)
                                    @if($i>rating($rides->user_id))
                                        <span class="fa fa-star"></span>
                                    @else
                                        <span class="fa fa-star checked"></span>
                                    @endif
                                @endfor

                            </p>
                            <p class="py-0 my-0 fs-12 lh-1-4">
                                ID-{{$rides->user_id}}<br>
                                Total trip: {{UserPostRide($rides->user_id)->count()}}<br>
                                Member since: {{date("d M,Y", strtotime(UserCreateat($rides->user_id)))}}<br>
                            </p>
                        </aside>
                    </td>
                    <td>
                        <a href="{{route('admin.pending.post').'/'.$rides->id}}" class="btn btn-sm btn-success my-1 fs-6">View
                            ride</a>
                    </td>
                </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>



@endsection

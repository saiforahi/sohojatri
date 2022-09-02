@extends('frontend.sp_panel.layout.app')

@section('content')

    <div class="content">

        <div class="container">
            <div class="card card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="row fs-12 lh-1-4">
                            <div class="col-4">
                                <h5 class="my-0">Passenger</h5>
                            </div>
                            <div class="col-8 border-left">
                                Name: {{UserName($booking->user_id)}}<br>
                                Phone: {{UserPhone($booking->user_id)}}<br>
                                Email: {{UserEmail($booking->user_id)}}
                            </div>
                        </div>
                        <div class="row fs-12 lh-1-4 mt-3">
                            <div class="col-4">
                                <h5 class="my-0">Driver</h5>
                            </div>
                            <div class="col-8 border-left">
                                Name: {{UserName(getRide($stopovers->post_id)->user_id)}}<br>
                                Phone: {{UserPhone(getRide($stopovers->post_id)->user_id)}}<br>
                                Email: {{UserEmail(getRide($stopovers->post_id)->user_id)}}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row fs-12 lh-1-4">
                            <div class="col-6 text-right">
                                Tracking Code:<br>
                                Date:<br>
                                Time:<br>
                                Payment Method:
                            </div>
                            <div class="col-6 text-left">
                                {{$stopovers->tracking}}<br>
                                {{$stopovers->date}}<br>
                                {{$stopovers->time}}:{{$stopovers->time2}}<br>
                                Cash on hand<br>

                                <div class="text-center p-1 border rounded">
                                    Amount Due<br>
                                    <p class="text-bold">{{$booking->fine}}৳</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <table class="table mt-5 table-bordered">
                    <thead class="bg-light">
                    <tr>
                        <th class="col-4">Description</th>
                        <th class="col">Seat</th>
                        <th class="col">price</th>
                        <th class="col">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            Departure: {{PostRideAddress($stopovers->post_id, $stopovers->going, 'location')}}<br>
                            Destination: {{PostRideAddress($stopovers->post_id, $stopovers->target, 'location')}}
                        </td>
                        <td>
                            {{$booking->seat}}
                        </td>
                        <td>
                            {{$stopovers->price}}৳
                        </td>
                        <td>
                            {{$booking->seat * $stopovers->price}}৳
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" class="border">
                            Discount<br>
                            Corporate<br>
                        </td>
                        <td>
                            -{{$booking->discount}}$<br>
                            00<br>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" class="bg-light border">
                            Total
                        </td>
                        <td class="bg-light">
                            {{$booking->amount}}
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

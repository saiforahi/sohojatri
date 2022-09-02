@extends('frontend.layout.app')
@section('content')

    <section class="my-5 overlay">
        <div class="container">
            <div class="card card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="row fs-12 lh-1-4">
                            <div class="col-3">
                                <h5 class="my-0">Passenger</h5>
                            </div>
                            <div class="col-9 border-left">
                                Name: {{UserName(Session('userId'))}}<br>
                                Phone: {{UserPhone(Session('userId'))}}<br>
                                Email: {{UserEmail(Session('userId'))}}
                            </div>
                        </div>
                        <div class="row fs-12 lh-1-4 mt-3">
                            <div class="col-3">
                                <h5 class="my-0">Driver</h5>
                            </div>
                            <div class="col-9 border-left">
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
                                    <p class="text-bold">{{BookingCancel(Session('userId'))}}৳</p>
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
                            {{$seat}}
                        </td>
                        <td>
                            {{$stopovers->price}}৳
                        </td>
                        <td>
                            {{$seat * $stopovers->price}}৳
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" class="border">
                            Discount<br>
                            Corporate<br>
                            Previous fine<br>
                        </td>
                        <td>
                            {{$price2}}৳<br>
                            {{$corporatePrice}}৳<br>
                            {{BookingCancel(Session('userId'))}}৳<br>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" class="bg-light border">
                            Total
                        </td>
                        <td class="bg-light">
                            <?php
                            $totalAmount = ((($seat * $stopovers->price) - $price2)-$corporatePrice)+BookingCancel(Session('userId'));
                            ?>
                           {{$totalAmount}}৳
                        </td>
                    </tr>

                    </tbody>
                </table>
                <form method="post" action="{{route('preview.store')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="tracking" value="{{$stopovers->tracking}}">
                    <input type="hidden" name="seat" value="{{$seat}}">
                    <input type="hidden" name="message" value="{{$message}}">
                    <input type="hidden" name="promo_code" value="{{$promo}}">
                    <input type="hidden" name="discount" value="{{$price2}}">
                    <input type="hidden" name="fine" value="{{BookingCancel(Session('userId'))}}">
                    <input type="hidden" name="corporate" value="{{$corporatePrice}}">
                    <input type="hidden" name="amount" value="{{$totalAmount}}">
                    <button type="submit" class="btn btn-primary float-right">Complete Booking</button>
                </form>
            </div>
        </div>
    </section>

@endsection
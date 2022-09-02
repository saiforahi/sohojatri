@extends('backend.layout.app')

@section('content')

    <div class="content">
        <h3 class="my-1">Faulty Trip</h3>
        Here you can find your faulty trip ride post.
        <div class="card mt-2">
            <div class="card-header text-center">
                <div class="row">
                    <div class="col">
                        Ride Information
                    </div>
                    <div class="col border-left">
                        Driver & Traveler
                    </div>
                    <div class="col border-left">
                        Destination
                    </div>
                    <div class="col border-left">
                        Faulty trip reason
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                @foreach($trip as $trips)
                    <?php
                    $stopovers = getSingleStopover($trips->tracking);
                    $s_location = explode(",", PostRideAddress($stopovers->post_id, $stopovers->going, 'location'));
                    $e_location = explode(",", PostRideAddress($stopovers->post_id, $stopovers->target, 'location'));
                    ?>
                    <div class="row border-bottom">
                        <div class="col text-left">
                            <i class="far fa-calendar-alt"></i> {{$stopovers->time}}
                            :{{$stopovers->time2}} {{date("l, F-d", strtotime($stopovers->date))}}
                            <br>
                            Total Seat: {{getRide($stopovers->post_id)->seat}}<br>
                            <i class="fas fa-wheelchair"></i> {{$stopovers->seat}} seat book<br>
                            Tracking: {{$stopovers->tracking}}<br>
                            Distance: {{$stopovers->distance}}<br>
                            Trip Id: {{$stopovers->post_id}}
                        </div>
                        <div class="col text-left border-left">
                            <b>Driver Name:</b><br>
                            <img class="author_img rounded"
                                 width="40px" height="40px"
                                 src="{{userInformation(getRide($stopovers->post_id)->user_id,'image')}}"
                                 alt=""><br>
                            <h6 class="my-0">{{userInformation(getRide($stopovers->post_id)->user_id,'name')}}</h6>

                            <b>Traveler Name:</b><br>@php $sl = 1; @endphp
                            @foreach(getBookingUser($stopovers->tracking) as $bookings)
                                {{$sl++}}. {{UserName($bookings->user_id)}}<br>
                            @endforeach
                        </div>
                        <div class="col text-left border-left">
                            <h4 class="my-0">@for($x = count($s_location)-2; $x < count($s_location); $x++)
                                    {{$s_location[$x].','}}
                                @endfor</h4>
                            <p>@for($x = 0; $x < count($s_location)-2; $x++)
                                    {{$s_location[$x].','}}
                                @endfor</p>

                            <h4 class="my-0">@for($x = count($e_location)-2; $x < count($e_location); $x++)
                                    {{$e_location[$x].','}}
                                @endfor</h4>
                            <p class="mb-0">@for($x = 0; $x < count($e_location)-2; $x++)
                                    {{$e_location[$x].','}}
                                @endfor</p>
                        </div>
                        <div class="col text-left border-left">
                            <p class="text-center">{{$trips->reason}}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{route('admin.faulty.trip')}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Faulty Trip</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf()
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tracking No</label>
                            <input name="tracking" type="text" class="form-control" id="exampleFormControlInput1"
                                   placeholder=""
                                   readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Faulty trip reason</label>
                            <textarea name="reason" class="form-control" id="exampleFormControlTextarea1"
                                      rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $('.faulty').click(function () {
            $('#exampleFormControlInput1').val($(this).data("id"));
            $('#exampleModal').modal('show');
        });
    </script>
@endpush

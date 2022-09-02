@extends('frontend.sp_panel.layout.app')

@section('content')

    <div class="content">
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('message') }}
            </div>
        @endif
        <h3 class="my-1">Upcoming ride edit</h3>
        Here you can edit your upcoming ride.
        <div class="card mt-2">
            <div class="card-header text-center">
                <div class="row">
                    <div class="col">
                        Ride Information
                    </div>
                    <div class="col border-left">
                        Driver
                    </div>
                    <div class="col border-left">
                        Destination
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                <?php
                $s_location = explode(",", $post->s_location);
                $e_location = explode(",", $post->e_location);
                ?>
                <div class="row border-bottom">
                    <div class="col text-left">
                        <i class="far fa-calendar-alt"></i> {{$post->d_time}}
                        :{{$post->d_time2}} {{date("l, F-d", strtotime($post->departure))}}
                        <br>
                        Total Seat: {{$post->seat}}<br>
                        Distance: {{$post->distance}}<br>
                        Trip Id: {{$post->id}}
                    </div>
                    <div class="col text-left border-left">
                        <b>Driver Name:</b><br>
                        <img class="author_img rounded"
                             width="40px" height="40px"
                             src="{{userInformation($post->user_id,'image')}}"
                             alt=""><br>
                        <h6 class="my-0">{{userInformation($post->user_id,'name')}}</h6>


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
                </div>

            </div>
            <div class="card-footer">
                <h6>Departure date and time update:</h6>
                <form autocomplete="off" method="post" action="{{route('upcoming.ride.edit.save')}}">
                    @csrf()
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="input-group mb-3 input-group-seamless">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3"><i class="fa fa-calendar-alt"
                                                                                        aria-hidden="true"></i></span>
                                </div>
                                <input type="text" autocomplete="off" class="form-control" data-provide="datepicker"
                                       name="departure"
                                       id="basicurl">
                            </div>
                        </div>
                        <div class="form-group col-md-4 d-inline-flex">
                            <select name="d_time" class="form-control w-25 mx-2">
                                @for($i=1;$i<=12;$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>:
                            <select name="d_time2" class="form-control w-25 mx-2">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">

                            <input type="submit" value="Update" class="btn btn-primary" id="inputZip">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

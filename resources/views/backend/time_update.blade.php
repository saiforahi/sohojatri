@extends('backend.layout.app')

@section('content')

    <div class="content">
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('message') }}
            </div>
        @endif
        <h3 class="my-1">Upcoming ride time update</h3>
        Here you can update rider request time.
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
                    <div class="col-1 border-left">
                        Status
                    </div>
                    <div class="col-1 border-left">
                        Action
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                @foreach($trip as $trips)
                    <?php
                    $post = getRide($trips->post_id);
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
                            Trip Id: {{$post->id}}<br>
                            Request Time: {{$trips->d_time}}
                            :{{$trips->d_time2}} {{date("l, F-d", strtotime($trips->departure))}}
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
                        <div class="col-1 text-left border-left">
                            @if($trips->status == 0)
                                <span class="badge badge-secondary">Request</span>
                            @else
                                <span class="badge badge-primary">Accepted</span>
                            @endif
                        </div>
                        <div class="col-1 text-left border-left">
                            @if($trips->status == 0)
                                <a href="{{route('admin.time.update',$trips->id)}}"
                                   class="btn btn-sm btn-primary my-2">Accept</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection

@extends('frontend.sp_panel.profile.layout.app')

@section('content')
<style type="text/css" media="screen">
    .conten {
        float: left;
        padding: 1.875em;
        width: 90%;
    }
</style>
<div class="conten">
    <style>
        .user-information td {
            width: 150px;
            margin: 10px 0;
        }

    </style>
    <h3>Your personal information</h3>
    <hr>

    <div class="card" style="border: 1px solid #b5a0a0;">
        <div class="card-body">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error</span>
                {{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endforeach
            @endif
            @if(session()->has('message'))
            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Alert</span>
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
            <form method="post" action="{{route('sp.account.profile.update')}}">
                {{csrf_field()}}
                <div class="row mb-4">
                    <div class="col-6 col-md-3 text-right">Gender:</div>
                    <div class="col-6 ml-2">{{$user->gender}}</div>
                </div>
                <div class="row my-2">
                    <div class="col-5 col-md-3 text-right">Fast Name:</div>
                    <div class="col-7">
                        <div class="input-group input-group-sm mb-3 col-md-7">
                            <input name="name" type="text" value="{{$user->name}}" class="form-control"
                                   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-5 col-md-3 text-right">Last Name:</div>
                    <div class="col-7">
                        <div class="input-group input-group-sm mb-3 col-md-7">
                            <input name="lname" type="text" value="{{$user->lname}}" class="form-control"
                                   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-5 col-md-3 text-right">Email:</div>
                    <div class="col-7">
                        <div class="input-group input-group-sm mb-3 col-md-7">
                            <input type="email" name="email" class="form-control" value="{{$user->email}}">
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-5 col-md-3 text-right">Phone:</div>
                    <div class="col-7">
                        <div class="input-group input-group-sm mb-3 col-md-7">
                            <input name="phone" type="text" value="{{$user->phone}}"
                                   class="form-control" {{$user->phone ? 'readonly':''}}>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-5 col-md-3 text-right">Date of Birth: <br>
                        <p>dd:mm:year</p></div>

                    <div class="col-4">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <input name="day" type="text" value="{{$user->day}}" class="form-control"
                                       aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="form-group col-md-4">
                                <input name="month" type="text" value="{{$user->month}}" class="form-control"
                                       aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="form-group col-md-4">
                                <input name="year" type="text" style="width: 105%;" value="{{$user->year}}"
                                       class="form-control"
                                       aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-5 col-md-3 text-right">Bio:</div>
                    <div class="col-7">
                        <div class="input-group input-group-sm mb-3 col-md-7">
                            <div style="    margin-left: -7px; border: 1px solid #c2e4f7;background-color: #eff8fd;"><p
                                    style="padding: 5px;"><i class="fas fa-exclamation-circle"
                                                             style="font-size: 19px;color: #70ccef;"></i> Tell other
                                    members about yourself and why they should want to travel with you(min. 10
                                    characters).</p>
                            </div>
                        </div>
                        <div class="row my-2 ">
                            <div class="col-7" style="margin-right: 0px;">
                                <textarea id="profile_general_biography" style="height: 118px;   width: 272px;"
                                          name="profile_general_biography" placeholder="Example: " maxlength="500">{{ $user->profile_general_biography}}</textarea>
                            </div>
                            <div class="col-5">
                                <div class="">
                                    <p class="u-">Please do not include:</p>
                                    <ul style="list-style-type:none;">
                                        <li>
                                            <span>Phone number</span>
                                        </li>
                                        <li>
                                            <span>Facebook account details</span>
                                        </li>
                                        <li>
                                            <span>Details about specific rides</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-6 col-md-3 text-right"></div>
                    <div class="col-6">
                        <button class="btn btn-sm btn-primary ml-2 px-5">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


@endsection

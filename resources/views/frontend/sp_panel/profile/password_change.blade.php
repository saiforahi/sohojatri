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
    <h3>Account password change</h3>
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
            <form method="post" action="{{route('sp.account.password')}}">
                {{csrf_field()}}
                <div class="row my-2">
                    <div class="col-5 col-md-3 text-right">Current Password:</div>
                    <div class="col-7">
                        <div class="input-group input-group-sm mb-3 col-md-7">
                            <input required name="current_password" type="password" class="form-control" placeholder="Enter your current password" autocomplete="current-password">
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-5 col-md-3 text-right">New Password:</div>
                    <div class="col-7">
                        <div class="input-group input-group-sm mb-3 col-md-7">
                            <input required name="new_password" type="password" class="form-control" placeholder="Enter your new password" autocomplete="current-password">
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-5 col-md-3 text-right">New Confirm Password:</div>
                    <div class="col-7">
                        <div class="input-group input-group-sm mb-3 col-md-7">
                            <input required name="new_confirm_password" type="password" class="form-control" placeholder="Confirm your new password" autocomplete="current-password">
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-6 col-md-3 text-right"></div>
                    <div class="col-6">
                        <button class="btn btn-sm btn-primary ml-2 px-5">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


@endsection

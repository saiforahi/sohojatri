@extends('frontend.sp_panel.profile.layout.app')

@section('content')
    <div class="content" style="background-color: white;height: 100vh">
        <div class="row">
            <div class="col-md-9 col-lg-7 col-xl-6 mx-auto">
                <form class="bg-white rounded border shadow p-5" action="{{route('sp.verification')}}"
                      method="post">
                    @csrf
                    <input type="hidden" name="{{ $type }}" value="{{ $destination }}"/>
                    <div id="intro" class="text-center">
                        <h4 class="mb-3 h5">Verification</h4>
                        <p class="mb-1">A OTP send to your {{$destination}}. Type the code and confirm your
                            account.</p>
                    </div>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert"
                                   aria-label="close">&times;</a>
                                {{$error}}
                            </div>
                        @endforeach
                    @endif
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="form-outline mb-2">
                        <input type="text" id="verification_code" name="verification_code"
                               value="{{ old('verification_code') }}" placeholder="Enter your verification code..."
                               class="form-control {{ $errors->has('verification_code') ? ' is-invalid' : '' }}"
                               required/>
                    </div>
                    <div class="form-group text-center mt-3">
                        <button name="submit" value="{{ $type }}" type="submit" class="btn btn-primary btn-sm btn-pill px-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@extends('frontend.layout.app')
@section('content')
    <style>
        .invalid-feedback {
            margin-top: -1.1rem;
        }

        .form-text {
            line-height: 17px;
            font-size: 12px;
        }
    </style>

    <section class="pb-5 py-4" id="section1">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
                    @if(isset($user))

                        <form name="myForm" class="bg-white rounded border shadow p-5 needs-validation"
                              action="{{route('forgot.password.change')}}"
                              method="post" novalidate>
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->user_id }}"/>
                            <input type="hidden" name="token" value="{{ $user->token }}"/>
                            <input type="hidden" name="id" value="{{ $user->id }}"/>
                            <div id="intro" class="text-center">
                                <h4 class="mb-3 h5">Forgot Password?</h4>
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
                            <div class="form-outline mb-4">
                                <input type="password" min="8" name="password" max="20" id="password"
                                       class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"/>
                                <label class="form-label" for="password">Old Password</label>
                                <div class="invalid-feedback password"></div>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="password" min="8" name="confirmed" max="20" id="confirmed"
                                       class="form-control {{ $errors->has('confirmed') ? ' is-invalid' : '' }}"/>
                                <label class="form-label" for="confirmed">Confirm Password</label>
                                <div class="invalid-feedback confirmed"></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group text-center mt-3">
                                <button type="submit" class="btn btn-primary btn-sm btn-pill px-5">Submit</button>
                            </div>
                        </form>


                    @else
                        <form class="bg-white rounded border shadow p-5" action="{{route('forgot.password')}}"
                              method="post">
                            @csrf
                            <div id="intro" class="text-center">
                                <h4 class="mb-3 h5">Forgot Password?</h4>
                                @if(isset($destination))
                                    <p class="mb-1">A OTP send to your {{$destination}}. Type the code and confirm your
                                        account.</p>
                                @endif
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
                        <!-- Email input -->
                            <div class="form-outline mb-2 @if(isset($destination)) d-none @endif">
                                <input type="text" id="email_phone" name="emailOrMobile"
                                       value="{{ $destination ?? old('emailOrMobile') }}"
                                       class="form-control {{ $errors->has('emailOrMobile') ? ' is-invalid' : '' }}"
                                       required/>
                                <label class="form-label" for="email_phone">Email address or Phone number</label>
                            </div>
                            @if(isset($destination))
                                <div class="form-outline mb-2">
                                    <input type="text" id="verification_code" name="verification_code"
                                           value="{{ old('verification_code') }}"
                                           class="form-control {{ $errors->has('verification_code') ? ' is-invalid' : '' }}"
                                           required/>
                                    <label class="form-label" for="verification_code">Verification Code</label>
                                </div>
                            @endif
                            <a href="{{route('sp.login')}}" class="text-muted float-right">Log In ?</a>
                            <div class="clearfix"></div>
                            <div class="form-group text-center mt-3">
                                <button type="submit" class="btn btn-primary btn-sm btn-pill px-5">Submit</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            let password = $('#password');
            let confirmed = $('#confirmed');
            Array.prototype.slice.call(forms).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    let condition = false;
                    if (password.val().length < 6 || password.val().length > 20) {
                        condition = true;
                        password.addClass('is-invalid')
                        $('.password').text('password minimum 6 and maximum 20 character')
                    } else {
                        condition = false;
                        password.removeClass('is-invalid')
                        password.addClass('is-valid')
                    }
                    if (password.val() != confirmed.val()) {
                        condition = true;
                        confirmed.addClass('is-invalid')
                        $('.confirmed').text('Password confirmation are not match')
                    }
                    if (condition) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>

@endsection

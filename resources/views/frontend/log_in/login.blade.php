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

    <section class="section-signup">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
                    <form class="bg-white rounded border shadow p-5 needs-validation" action="{{route('sp.login')}}"
                          method="post" novalidate>
                        @csrf
                        <div id="intro" class="text-center">
                            <h4 class="mb-2 h5">Sign In</h4>
                        </div>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
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
                        <div class="form-outline mb-4">
                            <input type="text" id="email_phone" name="emailOrMobile" value="{{ old('emailOrMobile') }}"
                                   class="form-control {{ $errors->has('emailOrMobile') ? ' is-invalid' : '' }}"
                                   required/>
                            <label class="form-label" for="email_phone">Email address or Phone number</label>
                            <div class="invalid-feedback">Enter your email or phone number...</div>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" min="8" name="password" max="20" id="password"
                                   class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required/>
                            <label class="form-label" for="password">Password</label>
                            <div class="invalid-feedback">Enter your password...</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col d-flex justify-content-center">
                                <div class="form-check">
                                    <input name="remember_me"
                                        class="form-check-input"
                                        type="checkbox"
                                        value="remember"
                                        id="form2Example3"
                                    />
                                    <label class="form-check-label" for="form2Example3"> Remember me </label>
                                </div>
                            </div>

                            <div class="col">
                                <a href="{{ url('/forgot-password') }}" style="color: gray;">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-sm btn-pill px-5">Log in</button>
                        </div>
                        <!-- Register buttons -->
                        <div class="text-center">
                            <p class="mb-1">Not a member? <a href="{{url('/registration') }}">Register</a></p>
                            <p>or sign up with:</p>
                            <button type="button" onclick="window.location='{{route('signup.facebook')}}'" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-facebook-f"></i>
                            </button>

                            <button type="button" onclick="window.location='{{route('signup.google')}}'" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-google"></i>
                            </button>

                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-twitter"></i>
                            </button>

                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-github"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>


@endsection

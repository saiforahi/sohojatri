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
                    <form class="bg-white rounded border shadow p-5 needs-validation" action="{{url('UserRegister')}}"
                          method="post" novalidate>
                        @csrf
                        <div id="intro" class="text-center">
                            <h4 class="mb-2 h5">Create a Sohojatri account</h4>
                            <p class="mb-1">It's Quick and Easy</p>
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
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                                           class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                           required/>
                                    <label class="form-label" for="first_name">First name</label>
                                    <div class="invalid-feedback">Enter your first name...</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                                           class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                           required/>
                                    <label class="form-label" for="last_name">Last name</label>
                                    <div class="invalid-feedback">Enter your last name...</div>
                                </div>
                            </div>
                        </div>
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

                        <div class="row mb-2">
                            <div class="form-group col">
                                <select id="inputState" name="day" class="form-control" required>
                                    <option value="" {{ (old("day") ? "":"selected") }} disabled>Day</option>
                                    @for($i=1;$i<=31;$i++)
                                        <option value="{{$i}}" {{ (old("day") == $i ? "selected":"") }}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col">
                                <select id="inputState" name="month" class="form-control" required>
                                    <option value="" selected disabled>Month</option>
                                    <option value="January" {{ (old("month") == "January" ? "selected":"") }}>January</option>
                                    <option value="February" {{ (old("month") == "February" ? "selected":"") }}>February</option>
                                    <option value="March" {{ (old("month") == "March" ? "selected":"") }}>March</option>
                                    <option value="April" {{ (old("month") == "April" ? "selected":"") }}>April</option>
                                    <option value="May" {{ (old("month") == "May" ? "selected":"") }}>May</option>
                                    <option value="June" {{ (old("month") == "June" ? "selected":"") }}>June</option>
                                    <option value="July" {{ (old("month") == "July" ? "selected":"") }}>July</option>
                                    <option value="August" {{ (old("month") == "August" ? "selected":"") }}>August</option>
                                    <option value="September" {{ (old("month") == "September" ? "selected":"") }}>September</option>
                                    <option value="October" {{ (old("month") == "October" ? "selected":"") }}>October</option>
                                    <option value="November" {{ (old("month") == "November" ? "selected":"") }}>November</option>
                                    <option value="December" {{ (old("month") == "December" ? "selected":"") }}>December</option>
                                </select>
                            </div>
                            <div class="form-group col">
                                <select id="inputState" name="year" class="form-control" required>
                                    <option value="" {{ (old("year") ? "":"selected") }} disabled>Year</option>
                                    @for($i=1950;$i<2021;$i++)
                                        <option value="{{$i}}" {{ (old("year") == $i ? "selected":"") }}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        Gender:
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="gender"
                                id="inlineRadio1"
                                value="Male"
                                @if(old('gender') == 'Male') checked @endif
                            />
                            <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="gender"
                                id="inlineRadio2"
                                value="Female"
                                @if(old('gender') == 'Female') checked @endif
                            />
                            <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                        <div class="form-group mt-2">
                            <small class="form-text text-muted text-justify">
                                By clicking Sign Up, you agree to our <a href="#">Terms</a> , <a href="#">Data
                                    Policy</a> and <a href="#">Cookie Policy</a>. You may receive notifications from us
                                and can opt out at any time.
                            </small>
                        </div>
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mt-3 mb-4">Sign up</button>
                        <!-- Register buttons -->
                        <div class="text-center">
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

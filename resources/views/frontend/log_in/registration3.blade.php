@extends('frontend.layout.app')
@section('content')
<style>
    a {
        color: #777777;
    }
    .form-signin input[type="number"] {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

<section class="section-signup" id="section1">

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-6 col-xl-4 mx-auto">
                <h2 class="text-center Helvetica-Bold text-black">Sign Up</h2>
                <form class="form-signin" action="{{url('UserRegister')}}" method="post">
                    {{csrf_field()}}

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
                    <label for="inputName" class="sr-only">Name</label>
                    <input type="text" id="inputName" name="name"
                           class="form-control shadow-none {{ $errors->has('name') ? ' is-invalid' : '' }}"
                           placeholder="Name" required autofocus>
                    <label for="inputEmail" class="sr-only">Phone</label>
                    <input type="number" id="inputEmail" name="phone"
                           class="form-control shadow-none {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                           placeholder="Phone Number" required controls="no">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="password" id="inputPassword"
                           class="form-control shadow-none {{ $errors->has('password') ? ' is-invalid' : '' }} mb-3"
                           placeholder="Password" required>
                    
                    <label>Date of Birth:</label>
                    <div class="form-group form-inline">
                        <select name="day" class="mr-3">
                            <option value="" selected disabled>Day</option>
                            @for($i=0;$i<31;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <select name="month" class="mr-3">
                            <option value="" selected disabled>Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July ">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November ">November</option>
                            <option value="December">December</option>
                        </select>
                        <select name="year">
                            <option value="" selected disabled>Year</option>
                            @for($i=1950;$i<2018;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        @if ($errors->has('dob'))
                        <div class="invalid-feedback">
                            {{ $errors->first('dob') }}
                        </div>
                        @endif
                    </div>
                    
                    
                    <div class="form-inline my-2 mb-4">
                        <label class="mr-4">Gender:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="exampleRadios1"
                                   value="Male">
                            <label class="form-check-label mr-3" for="exampleRadios1">
                                Male
                            </label>
                        </div>
                        <div class="form-check mx-2">
                            <input class="form-check-input" type="radio" name="gender" id="exampleRadios2"
                                   value="Female">
                            <label class="form-check-label" for="exampleRadios2">
                                Female
                            </label>
                            @if ($errors->has('gender'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gender') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <button class="btn btn-secondary btn-block border-0" style="background-color: #6f7283"
                            type="submit">Create Account
                    </button>
                    <br>
                    <p style="font-size: 13px;">Already have an account? <a href="/login">Log in</a></p>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection
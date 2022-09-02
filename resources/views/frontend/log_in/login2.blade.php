@extends('frontend.layout.app')
@section('content')


    <section class="section-login" id="section1">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 col-xl-4 mx-auto">
                    <h2 class="text-center Helvetica-Bold text-black">Log in</h2>
                    <form class="form-signin" method="post" action="{{route('sp.login')}}">
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
                        <label for="inputEmail" class="sr-only">Email address</label>
                        <input type="number" id="inputEmail" name="phone" class="form-control shadow-none" placeholder="Phone Number"
                               required
                               autofocus>
                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" name="password" id="inputPassword" class="form-control shadow-none"
                               placeholder="Password" required>
                        <div class="checkbox mb-3">
                            <label class="forget-password">
                                <a href="{{route('forgot.password')}}" style="color: rgb(119,119,119); font-size: 13px;">Forgot password?</a>
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block border-0" style="background-color: #6f7283"
                                type="submit">Log me in
                        </button>
                        <br>
                        <p style="font-size: 13px;">New to Durpalla? <a href="/login">Sign up</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection

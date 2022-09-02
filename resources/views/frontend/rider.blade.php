@extends('frontend.layout.app')
@section('content')

    <section class="my-5">
        <div class="container">

            <div class="row single-post-area">
                <div class="text-center mb-3 mx-auto col-12">

                </div>
                <div class="col-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget author_widget">
                            <img class="author_img rounded-circle" src="{{$user->image}}"
                                 width="100px" height="100px"
                                 alt="">
                            <h4 class="text-capitalize">{{$user->name}} {{$user->lname}}</h4>
                            {{date("Y") - $user->year}} y/o
                            <p class="fs-8 my-0">
                                @for($i=1;$i<=5;$i++)
                                    @if($i>rating($user->user_id))
                                        <span class="fa fa-star"></span>
                                    @else
                                        <span class="fa fa-star checked"></span>
                                    @endif
                                @endfor
                            </p>
                            <div class="">
                                <a href="#" class="text-muted mr-1"><i class="fa fa-facebook"></i></a>
                                <a href="#" class="text-muted mr-1"><i class="fa fa-twitter"></i></a>
                                <a href="#" class="text-muted mr-1"><i class="fa fa-github"></i></a>
                                <a href="#" class="text-muted mr-1"><i class="fa fa-behance"></i></a>
                            </div>
                            <p class="text-justify ml-3 my-2 mb-3" style="line-height: 18px;">
                                {{$user->profile_general_biography}}
                            </p>
                            <p class="text-justify ml-3">
                                {!!userInformation($user->user_id,'phoneIsVerified') == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i> '!!}
                                Phone Verified<br>
                                {!!userInformation($user->user_id,'emailIsVerified') == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i> '!!}
                                Email Verified<br>
                                {!!verification($user->user_id)->nid_status == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i> '!!}
                                NID Verified<br>
                                {!!verification($user->user_id)->passport_status == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i> '!!}
                                Passport Verified<br>
                                {!!verification($user->user_id)->driving_status == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i> '!!}
                                Driving Licence Verified<br>
                            </p>
                            <div class="br"></div>
                            <p class="text-justify ml-3">
                                {{$all_post->count()}} rides published<br>
                                {{$resource}} Resource<br>
                                Member since {{$user->created_at->format('M Y')}}<br><br>
                                <a href="#">Report this member</a>
                            </p>
                        </aside>
                    </div>
                </div>
                <div class="col-8">
                    <aside class="single_sidebar_widget popular_post_widget">
                        <h3 class="widget_title">Rider Upcoming Posts</h3>
                        @foreach($all_post as $posts)
                            @if(strtotime($posts->departure) >= strtotime('today UTC'))
                                <h3 class="fs-10">{{$posts->departure}}</h3>
                                <p class="fs-12 ml-3">Departure: {{$posts->s_location}}<br>
                                    Destination: {{$posts->e_location}}</p>
                                <hr>
                            @endif
                        @endforeach
                    </aside>
                </div>
            </div>
        </div>
    </section>

@endsection

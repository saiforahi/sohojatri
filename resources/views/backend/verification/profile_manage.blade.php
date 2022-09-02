@extends('backend.layout.app')

@section('content')

    <style type="text/css" media="screen">
        .cardHead{
            height: 30px;
            padding: 2px 20px;
        }
        .reject{
                text-align: center;
                color: wheat;
                margin: 1px;
                padding-left: 177px;
        }
        .messreject{
            width: 70%;
        }
       
         .imagezoom{
                     padding: 2px;
                    margin-left: 35px;
                    margin-bottom: 10px;
        } .imagezoom1{
                   padding: 2px;
                   margin-left: 85px;
                   margin-bottom: 8px;
                              
        }
        .imgshow{
             margin-left: 35px;

        }
       .imgshow1{
          margin-left: 60px;
        }
        .imgshowmodal{
             margin-left: 35px;
             padding-left: 112px;
             padding-right: 90px;
             height: 136px;
            width: 85px;
            padding-bottom: 2px;
        
        }
       
    </style>
    <div class="content">

        @if(isset($verifications))
            <div class="card card-body shadow border">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 my-2">
                            Coustomer ID: {{$verifications->user_id}} <br>
                            Name:  {{UserNameIs($verifications->user_id)}}<br>
                            Email:  {{UserEmail($verifications->user_id)}}<br>
                            Phone:  {{UserPhone($verifications->user_id)}}
                        </div>
                        <div class="col-6 my-2">
                           Last Login:{{date('d-m-y',strtotime(UserUpdatedat($verifications->user_id)))}} <br>
                           No of Login:{{UserLogincount($verifications->user_id)}}<br>
                           Sign Up Date:{{date('d-m-y', strtotime(UserCreateat($verifications->user_id)))}}
                          
                        </div>
                        <div class="col-6 my-2" style="width: 60%; margin: 15px auto; box-shadow: 0px 0px 5px 5px #9e9c9c; padding: 0px;border-radius: 5px 0 0 5px;">
                             
                            <div class="card-header bg-success text-white cardHead">
                               Customer Profile Request:  &nbsp;
                            </div>
                        <div class="card-body" style="height: 238px;width: 250%;">
                              
                           <!--   
                                                      <img src="{{asset('/'.$verifications->nid_image1)}}" class="img-thumbnail w-25 imgshow" style="height: 50%;width: 50%"> -->
                            <img src="{{asset('/'.$verifications->image)}}" class="img-thumbnail w-25 imgshow1" style="height: 100%;width: 50%" onerror="this.src='{{ asset('/public/user/noimage.png') }}'"><br>
                           <!--  <button type="button" class="btn btn-primary btn-sm imagezoom "style="margin-left: 80px;
                                                     margin-top: 7px;" data-toggle="modal" data-target="#imgmodal"><i class="fas fa-plus" ></i></button>  -->
                            <!--  <button type="button" class="btn btn-primary btn-sm imagezoom1" style="margin-left: 152px;
                                margin-top: 7px;" data-toggle="modal" data-target="#imgmodal1"><i class="fas fa-plus"></i></button><br> -->
                           
                            
                           
                            <!-- <img src="{{asset('/'.$verifications->passport_image1)}}" class="img-thumbnail w-25 imgshow" style="height: 50%;width: 50%">
                                                       <img src="{{asset('/'.$verifications->passport__image2)}}" class="img-thumbnail w-25 imgshow1" style="height: 50%;width: 50%"><br>
                            <button type="button" class="btn btn-primary btn-sm imagezoom" style="margin-left: 80px;
                                margin-top: 7px;"  data-toggle="modal" data-target="#imgmodal"><i class="fas fa-plus"></i></button> 
                            <button type="button" class="btn btn-primary btn-sm imagezoom1" style="margin-left: 152px;
                                margin-top: 7px;" data-toggle="modal" data-target="#imgmodal1"><i class="fas fa-plus"></i></button><br>
                                                      
                                                       
                                                      <img src="{{asset('/'.$verifications->driving_image1)}}" class="img-thumbnail w-25 imgshow" style="height: 50%;width: 50%">
                                                     <img src="{{asset('/'.$verifications->driving__image2)}}" class="img-thumbnail w-25 imgshow1" style="height: 50%;width: 50%"><br>
                                                       <button type="button" class="btn btn-primary btn-sm imagezoom" style="margin-left: 80px;
                                margin-top: 7px;" data-toggle="modal" data-target="#imgmodal"><i class="fas fa-plus"></i></button> 
                             <button type="button" class="btn btn-primary btn-sm imagezoom1" style="margin-left: 152px;
                                margin-top: 7px;" data-toggle="modal" data-target="#imgmodal1"><i class="fas fa-plus"></i></button><br> -->
                            
                            
                            </div>
                            
                        </div>
                        <!-- <div class="col-6 my-2" style="border-left: 1px solid #eee; width: 30%; margin: 15px auto; box-shadow: 0px 0px 5px 5px #9e9c9c;padding: 0px;border-radius: 0px 5px 5px 0px;">
                             <div class="card-header bg-success text-white cardHead">
                                Existing Verification 
                            </div>
                            <div class="card-body">
                                 
                           {{ (isset ($userinfo->existing) && !empty($userinfo->existing))? $userinfo->existing: "NULL" }}
                            </div>
                        </div> -->
                    
                        <div class="col-8 my-2">
                            <!-- <img src="{{asset('storage/car/'.$verifications->car_image1)}}" class="img-thumbnail w-25">
                            <img src="{{asset('storage/car/'.$verifications->car_image2)}}" class="img-thumbnail w-25"> -->
                        </div>
                        <div class="col-6 my-2">

                        </div>
                    </div>
                    
                    <form method="post" class="row" action="{{ url('/profile_manage_photo_approve/'.$verifications->id) }}">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$verifications->id}}">
                     
                        <div class="col-6 my-2">
                           
                        </div>
                        <div class="col-6 my-2">
                            <button name="btn_s" value="app" type="submit" class="btn btn-sm btn-success">Approve</button>
                            <a  class="btn btn-sm btn-primary" href="{{ route('profile.manage') }}">Pending</a>
                            <button name="" value="" type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-sm btn-danger">Reject</button>
                        </div>
                    </form>

                </div>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-success text-white">
                All Coustomer Profile Information
            </div>
            <div class="card-body">
                <table class="table border display" id="table_id">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Coustomer Id</th>
                        <th>Coustomer Name</th>
                         <th>Joning Date</th>
                        <th>Car No</th>
                         <th>NID No</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $listNum = 1; ?>
                    @foreach($users as $verification)
                        <tr>
                            <td>{{$listNum}}</td>
                            <td>{{$verification->user_id}}</td>
                            <td>{{UserNameIs($verification->user_id)}}</td>
                             <td>{{date('d-m-y', strtotime($verification->created_at))}}</td>
                            <td> 
                               @if(UserNumberPlate($verification->user_id)) {{UserNumberPlate($verification->user_id)}}@else NULL @endif
                            <!-- @if(isset($verification->nid_status)&& $verification->nid_status==0 ) NID
                                @elseif(isset($verification->passport_status) && $verification->passport_status==0) Passport
                                @elseif(isset($verification->driving_status)&& $verification->driving_status==0) Driving @endif -->

                              </td> 
                              <td> @if(UserNid($verification->user_id)){{UserNid($verification->user_id)}}@else NULL @endif</td>

                            <td>
                                 @if($verification->email){{ $verification->email}} @else NULL @endif
                              <!-- @if($verification->existing) {{ $verification->existing }} @else NULL @endif -->
                            
                                <!--@if(isset($verification->nid_status) &&  !$verification->nid_status==1) Passport-->
                                <!--@elseif (isset($verification->nid_status) && $verification->nid_status==2)NULL  @endif-->

                                <!--@if(isset($verification->passport_status) && !$verification->passport_status==1) NID-->
                                <!--@elseif(isset($verification->passport_status) && $verification->passport_status==2)NULL  @endif-->
                                <!--@if(isset($verification->driving_status) &&  !$verification->driving_status==1)NID-->
                                <!--@elseif(isset($verification->driving_status) && $verification->driving_status==2) NULL-->
                                <!--@endif-->
                                
                                </td>
                                <td>@if($verification->phone){{ $verification->phone }} @else NULL @endif</td>
                                  <td><img src="{{asset('/'.$verification->image)}}"
                                                        style="height:25px;width:40px;" onerror="this.src='{{ asset('/public/user/noimage.png') }}'"></td>
                            <td>
                                <a href="{{route('profile.manage').'/'.$verification->id}}"
                                   class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>

                            </td>
                        </tr>
                        <?php $listNum++; ?>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header card-header bg-success text-white cardHead" style="padding: 2px;text-align: center;">
        <p class="modal-title reject" id="exampleModalLongTitle" style="text-align: center;">Reject Reason</p>
        <button type="button" class="close" data-dismiss="modal"  aria-label="Close">
          <span aria-hidden="true" style="margin: 8px">&times;</span>
        </button>
      </div>
      <div class="modal-body" style=" padding-left: 103px;">
          @if(isset($verifications))
        <form method="post" class="row" action="{{url('profile_manage-photo/'.$verifications->id)}}">
                        {{csrf_field()}}
                       
                    
                          <input type="hidden" name="id" value="{{$verifications->id}}">
                        <select name="cbo_rej_mess" id='cbo_rej_mess' class="messreject" style="padding-left: 61px;">
                               <option value="">---Select Reason---</option>
                             
                                @foreach ($rejectphoto as $reject)
                                     <option value="{{$reject->reject_photo}}">{{$reject->reject_photo}}</option>
                                @endforeach
                               
                           </select> 
                     <div style="padding-right: 20px;"></div>
                       <a type="button" class="btn btn-sm" data-toggle="modal" data-target="#addreject">&nbsp;<i class="fa fa-plus"></i></a>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
       <button name="btn_s" value="rej" type="submit" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-success btn-sm ">Update</button>
      </div>
       </form>
     @endif
    </div>
  </div>
</div>

<div class="modal fade" id="addreject" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header card-header bg-success text-white cardHead" style="padding: 2px;text-align: center;">
        <h5 class="modal-title reject" id="exampleModalLongTitle" style="text-align: center;">Reject Reason Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" style="margin: 8px">&times;</span>
        </button>
      </div><br>
      <div class="modal-body" style="padding-left: 44px;
    padding-right: 124px;">
       <form class="row" id="addform" method="post" action="{{url('/photo_reject')}}">
 
    
        {{ csrf_field() }}
  
   
    <input type="text" name="reject_photo" class="form-control" id="reject_photo" placeholder="Reject Reason">


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm ">Save</button>
      </div>
       </form>
    </div>
  </div>
</div>
</div>



<!-- Modal image -->

<div class="modal fade" id="imgmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
       @if(isset($verifications))
      <div class="modal-body" style="height: 100%;
    width: 321%;">
  
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
<!-- -->
<div class="modal fade" id="imgmodal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
       @if(isset($verifications))
      <div class="modal-body" style="height: 100%;
    width: 321%;">
     
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#cbo_rej_mess').change(function(event) {
        $('#rej_mess').val($(this).val());
    });

</script>
@endsection


<script type="text/javascript">
 
</script>
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
                   /*  margin-left: 52px; */
                    margin-bottom: 10px;
        } .imagezoom1{
                   padding: 2px;
                 /*   margin-left: 52px; */
                   margin-bottom: 8px;
                              
        }
        .imgshow{
             margin-left: 10px;

        }
       .imgshow1{
          margin-left: 31px;
        }
        .imgshowmodal{
             margin-left: 35px;
             padding-left: 112px;
             padding-right: 90px;
             height: 136px;
            width: 85px;
            padding-bottom: 2px;
        
        }
       .imageposition{
            height: 50%;
          width: 25%!important;
       }
       .btn_close{
                     float: right;padding: 3px 15px;
                    }
                    .btn_close:hover{
                        background-color: #d00000;
                    }    
                    .border_radius_nun{
                        border-radius: 0px;
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
                        <div class="col-9 my-2" style="width: 60%; margin: 15px auto; box-shadow: 0px 0px 5px 5px #9e9c9c; padding: 0px;border-radius: 5px 0 0 5px;">
                             
                            <div class="card-header bg-success text-white cardHead border_radius_nun"  style="padding: 0px 0px 0px 20px;">
                                Verification  Approve List:  &nbsp;(   {{ (isset($verifications->existing) && !empty($verifications->existing))? $verifications->existing:'NULL' }} )
                                <a type="" class="btn btn-sm bottom-right btn_close" style="" href="{{ route('admin.approve.verification') }}"><i class="fas fa-times"></i></a>
                            </div>
                        <div class="card-body" style="height: 196px;">
                           <div class="row">
                             @if($verifications->nid_status==1)
                            <div class="col-md-4">
                                  <img src="{{asset('/'.$verifications->nid_image1)}}" class="img-thumbnail  imgshow imageposition" style="   ">
                            <img src="{{asset('/'.$verifications->nid_image2)}}" class="img-thumbnail imgshow1 imageposition" style=" "><br>

                             <button type="button" class="btn btn-primary btn-sm  imagezoom" data-toggle="modal" data-target="#imgmodal" style="  margin-top: 7px; margin-left: 28px;"> <i class="fas fa-plus"></i></button> 
                             <button type="button" class="btn btn-primary btn-sm imagezoom1"  data-toggle="modal" data-target="#imgmodal1" style=" margin-top: 7px;margin-left: 65px;"> <i class="fas fa-plus"></i></button>
                            </div>
                             @endif
                         
                               @if($verifications->passport_status==1)
                            <div class="col-md-4">
                               <img src="{{asset('/'.$verifications->passport_image1)}}" class="img-thumbnail  imgshow imageposition" style=" ">
                           <img src="{{asset('/'.$verifications->passport_image2)}}" class="img-thumbnail  imgshow1 imageposition" style=" "><br>

                            <button type="button" class="btn btn-primary btn-sm imagezoom" data-toggle="modal" data-target="#imgmodalpassport" style="    margin-top: 7px; margin-left: 28px;"> <i class="fas fa-plus"></i></button> 
                            <button type="button" class="btn btn-primary btn-sm imagezoom1" data-toggle="modal" data-target="#imgmodalpassport2" style="    margin-top: 7px;margin-left: 65px;"> <i class="fas fa-plus"></i></button> 
                            </div>
                            @endif
                             @if($verifications->driving_status==1)
                       <div class="col-md-4">
                            <img src="{{asset('/'.$verifications->driving_image1)}}" class="img-thumbnail  imgshow imageposition" style="">
                         <img src="{{asset('/'.$verifications->driving_image2)}}" class="img-thumbnail  imgshow1 imageposition" style=""><br>
                         <button type="button" class="btn btn-primary btn-sm imagezoom" data-toggle="modal" data-target="#imgmodaldriving" style="     margin-top: 7px;margin-left: 28px;"> <i class="fas fa-plus"></i></button> 
                             <button type="button" class="btn btn-primary btn-sm imagezoom1" data-toggle="modal" data-target="#imgmodaldraving2" style="    margin-top: 7px;margin-left: 65px;"> <i class="fas fa-plus"></i></button> 
                       </div>
                        @endif
                             
                          
                            </div>
                            
                            </div>
                            
                        </div>
                       <!--  <div class="col-3 my-2" style="border-left: 1px solid #eee; width: 30%; margin: 15px auto; box-shadow: 0px 0px 5px 5px #9e9c9c;padding: 0px;border-radius: 0px 5px 5px 0px;">
                           <div class="card-header bg-success text-white cardHead">
                              Existing Verification 
                          </div>
                          <div class="card-body">
                               
                           {{ (isset($verifications->existing) && !empty($verifications->existing))? $verifications->existing:'NULL' }}
                          </div>
                                              </div> -->
                        
                       
                        <div class="col-8 my-2">
                            <!-- <img src="{{asset('storage/car/'.$verifications->car_image1)}}" class="img-thumbnail w-25">
                            <img src="{{asset('storage/car/'.$verifications->car_image2)}}" class="img-thumbnail w-25"> -->
                        </div>
                       
                    </div>
                    
                    <form method="post" class="row" action="{{url('admin-pending-verification-change'.'?a=nid&b=del&c='.$verifications->id)}}">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$verifications->id}}">
                     
                        <div class="col-6 my-2">
                           
                        </div>
                        <div class="col-6 my-2">
                           <!--  <button name="btn_s" value="app" type="submit" class="btn btn-sm btn-success">Approve</button> -->
                         <!--    <a type="" class="btn btn-sm btn-primary" style="    margin-left: 171px;" href="{{ route('admin.approve.verification') }}">Back</a> -->
                           <!--  <button name="" value="" type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-sm btn-danger">Reject</button> -->
                        </div>
                    </form>

                </div>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-success text-white">
                All Approve Verification Customer
            </div>
            <div class="card-body">
                <table class="table border display" id="table_id">
                    <thead>
                  <tr>
                        <th>Id</th>
                        <th>User Id</th>
                        <th>User Name</th>
                         <th>Approve Date</th>
                        <th>Verification For</th>
                        <th>Existing Verification</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $listNum = 1; ?>
                    @foreach($verification as $verifications)
                        <tr>

                            <td>{{$listNum}}</td>
                            <td>{{$verifications->user_id}}</td>
                            <td>{{UserNameIs($verifications->user_id)}}</td>
                             <td>{{date('d-m-y', strtotime($verifications->updated_at))}}</td>
                            <td> @if(isset($verifications->nid_status)&& $verifications->nid_status==1 ) NID
                                @elseif(isset($verifications->passport_status) && $verifications->passport_status==1) Passport
                                @elseif(isset($verifications->driving_status)&& $verifications->driving_status==1) Driving @endif</td> 
                              <td> 
                                {{ (isset($verifications->existing_mess) && !empty($verifications->existing_mess))? $verifications->existing_mess:"NULL" }}
                            </td> 
                            <td> <a href="{{route('admin.approve.verification').'/'.$verifications->id}}"
                                   class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a></td>
                        </tr>
                        <?php $listNum++; ?>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
<!--image modal-->
<div class="modal fade" id="imgmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
       @if(isset($verifications))
      <div class="modal-body" style="height: 100%;
    width: 321%;">
       @if($verifications->nid_image1)
       <img src="{{asset('/'.$verifications->nid_image1)}}" class="img-thumbnail w-25 imgshowmodal" style="">
          @endif
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="imgmodal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
       @if(isset($verifications))
      <div class="modal-body" style="height: 100%;
    width: 321%;">
       @if($verifications->nid_image2)
       <img src="{{asset('/'.$verifications->nid_image2)}}" class="img-thumbnail w-25 imgshowmodal" style="">
          @endif
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="imgmodalpassport" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
       @if(isset($verifications))
      <div class="modal-body" style="height: 100%;
    width: 321%;">
       @if($verifications->nid_image1)
       <img src="{{asset('/'.$verifications->passport_image1)}}" class="img-thumbnail w-25 imgshowmodal" style="">
          @endif
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="imgmodalpassport2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
       @if(isset($verifications))
      <div class="modal-body" style="height: 100%;
    width: 321%;">
       @if($verifications->nid_image2)
       <img src="{{asset('/'.$verifications->passport_image2)}}" class="img-thumbnail w-25 imgshowmodal" style="">
          @endif
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
<!---->
<div class="modal fade" id="imgmodaldriving" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
       @if(isset($verifications))
      <div class="modal-body" style="height: 100%;
    width: 321%;">
       @if($verifications->nid_image1)
       <img src="{{asset('/'.$verifications->driving_image1)}}" class="img-thumbnail w-25 imgshowmodal" style="">
          @endif
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="imgmodaldraving2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
       @if(isset($verifications))
      <div class="modal-body" style="height: 100%;
    width: 321%;">
       @if($verifications->nid_image2)
       <img src="{{asset('/'.$verifications->driving_image2)}}" class="img-thumbnail w-25 imgshowmodal" style="">
          @endif
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>

@endsection
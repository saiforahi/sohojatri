@extends('backend.layout.app')

@section('content')

    <div class="content">

        @if(isset($verifications))
            <div class="card card-body shadow border">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 my-2" >
                            Coustomer ID: {{$verifications->user_id}} <br>
                            Name:  {{UserNameIs($verifications->user_id)}}<br>
                            Email:  {{UserEmail($verifications->user_id)}}<br>
                            Phone:  {{UserPhone($verifications->user_id)}}
                        </div>
                        <div class="col-6 my-2">
                           Address:  <br>
                           No of Login: <br>
                           Sign Up Date:
                        </div>
                       <!--  <div class="col-6 my-2" style="border: 1px solid #eee; width: 60%; margin: 15px auto; box-shadow: 0px 0px 5px 5px #9e9c9c;">
                            <div class=" bg-success text-white" style="text-align: center;">
                             Disapprove Verification
                           </div>
                           <div class="card-header ">
                            NID: <br>
                           Image First: <img src="{{asset('/'.$verifications->nid_image1)}}" class="img-thumbnail w-25"><br>
                          Image Last: <img src="{{asset('/'.$verifications->nid_image2)}}" class="img-thumbnail w-25">
                           </div>
                       </div> -->
                        <!-- <div class="col-6 my-2" style="border: 1px solid #eee; width: 30%; margin: 15px auto; box-shadow: 0px 0px 5px 5px #9e9c9c;">
                            <div class="bg-success text-white" style="text-align: center;">
                              Existing Verification
                            </div>
                        
                          NID:{{UserEmail($verifications->user_id)}}
                        </div> -->
                        <div class="col-6 my-2">
                           
                        </div>
                        <div class="col-6 my-2">
                            
                        </div>
                        <div class="col-6 my-2">
                            
                        </div>
                        <div class="col-8 my-2">
                            <!-- <img src="{{asset('storage/car/'.$verifications->car_image1)}}" class="img-thumbnail w-25">
                            <img src="{{asset('storage/car/'.$verifications->car_image2)}}" class="img-thumbnail w-25"> -->
                        </div>
                        <div class="col-6 my-2">

                        </div>
                    </div>
                    <form method="post" class="row" action="">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$verifications->id}}">
                        <div class="col-6 my-2">
                           <!--  <div class="form-group row">  
                               <label for="staticEmail" class="col-sm-3 col-form-label">Car type:</label>
                               <div class="col-sm-8">
                                   <select class="form-control-sm form-control" name="type">
                                       <option value="Comfort" {{$verifications->car_type == "Comfort"?'selected':''}}>Comfort</option>
                                       <option value="Luxury" {{$verifications->car_type == "Luxury"?'selected':''}}>Luxury</option>
                                   </select>
                               </div>
                           </div> -->
                        </div>
                        <div class="col-6 my-2">
                           <!--  <button type="submit" class="btn btn-sm btn-success">Approve</button> -->
                            <a type="" class="btn btn-sm btn-primary" href="{{ route('admin.disapprove.verification') }}">Pending</a>
                          
                        </div>
                    </form>

                </div>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-success text-white">
                All Disapprove Verification Customer
            </div>
            <div class="card-body">
                <table class="table border display" id="table_id">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>User Id</th>
                        <th>User Name</th>
                        <th>Apply Date</th>
                        <th>Reject Date</th>
                        <th>Request For</th>
                        <th>Reject For</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $listNum = 1; ?>
                    @foreach($verification as $verifications)
                        <tr>
                           <td>{{$listNum}}</td>
                            <td>{{$verifications->user_id}}</td>
                             <td> {{UserNameIs($verifications->user_id)}}</td>
                            
                             <td>{{date('d-m-y', strtotime($verifications->created_at))}}</td>
                             <td>{{date('d-m-y', strtotime($verifications->updated_at))}}</td>
                             <td>@if($verifications->nid_status == 2) NID 
                            @elseif($verifications->passport_status == 2) Passport
                           @elseif($verifications->driving_status == 2) Driving @endif</td>
                           <td>{{$verifications->rejected_message}}</td>
                            <td>
                                <a href="{{route('admin.disapprove.verification').'/'.$verifications->id}}"
                                   class="btn btn-sm btn-success">View</a>

                            </td>
                        </tr>
                        <?php $listNum++; ?>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>



@endsection
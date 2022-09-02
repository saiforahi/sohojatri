@extends('frontend.sp_panel.layout.app')

@section('content')

    <div class="content">
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

        <div class="card">
            <div class="card-header">
                Sp Car list
                <button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">Add
                    more car
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped table-hover" cellspacing="0" id="DataTable">
                    <thead>
                    <tr>
                        <th>Sl.</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Number Plate</th>
                        <th>Image Front</th>
                        <th>Image Back</th>
                        <th>Fuel type</th>
                        <th>Kilometers run</th>
                        <th>Car type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $listNum = 1; ?>
                    @foreach($car as $cars)
                        <tr>
                            <td>{{$listNum}}</td>
                            <td>{{CarBrandById($cars->brand_id)}}</td>
                            <td>{{$cars->model}}</td>
                            <td>{{$cars->number_plate}}</td>
                            <td><img src="{{asset('/'.$cars->car_image1)}}"  style="height:20px;width:40px;" onerror="this.src='{{ asset('/public/car/noimg.png') }}'">
                            </td>
                             <td><img src="{{asset('/'.$cars->car_image2)}}" style="height:20px;width:40px;" onerror="this.src='{{ asset('/public/car/noimg.png') }}'">
                            </td>
                            <td>{{$cars->fuel}}</td>
                            <td>{{$cars->kilometers}}</td>
                            <td>{{$cars->car_type}}</td>
                             <td>
                                @if($cars->status == 0)
                                    <span class="badge badge-pill badge-danger">Pending</span>
                                @else
                                    <span class="badge badge-pill badge-success">Approved</span>
                                @endif
                            </td>
                            <td>
                                  @if($cars->status == 1)
                                  <a href="{{url('sp-active-car/'.$cars->id)}}"
                                   class="btn btn-sm btn "><i class="fa fa-toggle-off" style="font-size: 22px; " aria-hidden="true"></i></a>
                                    @elseif($cars->status == 2)
                                     <a href="{{url('sp-inactive-car/'.$cars->id)}}"
                                   class="btn btn-sm btn "><i class="fa fa-toggle-off" style="font-size: 22px;color: #6a6f6a " aria-hidden="true"></i></a>
                                   @elseif($cars->status == 0)
                                  

                                   <a href="{{url('sp-delete-car?Delete='.$cars->id)}}"
                                   class="btn btn-sm btn delete"><i class="fa fa-trash" style="font-size: 22px;color: #6a6f6a" aria-hidden="true"></i></a>
                                   @endif

                            </td>
                        </tr>
                        <?php $listNum++; ?>
                    @endforeach

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #edeff1">
                    <h5 class="modal-title" id="exampleModalLabel">Add Car Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('sp.addcar')}}" enctype="multipart/form-data" style="margin: 50px;">
                    {{csrf_field()}}
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-3 col-form-label">Brand</label>
                            <div class="col-md-9">
                                <select class="form-control" name="brand">
                                    @foreach($car_brand as $car_brands)
                                        <option value="{{$car_brands->id}}">{{$car_brands->brand_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label">Model</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="modal" id="modal" placeholder="Model">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label">Car Number Plate:</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="car_number" id="modal"
                                       placeholder="Car Number Plate">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label">Car Image Front</label>
                            <div class="col-md-9">
                                <input type="file" name="car_image1" id="modal" placeholder="Model">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label">Car Image Back</label>
                            <div class="col-md-9">
                                <input type="file" name="car_image2" id="modal" placeholder="Model">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label">Fuel type</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="fuel" id="fuel" placeholder="Fuel type">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label">kilometers run</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="kilometers" id="kilometers"
                                       placeholder="kilometers run">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label">Registration Year</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="regYear" id="kilometers"
                                       placeholder="Registration Year">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label">Model Year</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="modelYear" id="kilometers"
                                       placeholder="Model Year">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Car</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
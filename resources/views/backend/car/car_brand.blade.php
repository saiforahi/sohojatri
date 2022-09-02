@extends('backend.layout.app')

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
                Car Brand list
                <button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">Add
                    Car Brand
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover display" cellspacing="0" id="DataTable table_id">
                    <thead>
                    <tr>
                        <th>Sl.</th>
                        <th>Brand Name</th>
                        <th>Date</th>
                        <th>Brand Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php $listNum = 1; ?>
                    @foreach($car_brand as $cars)
                        <tr>
                            <td>{{$listNum}}</td>
                            <td>{{($cars->brand_name)}}</td>
                            <td>{{date('d-m-y', strtotime($cars->created_at))}}</td>
                            
                           <td>{{$cars->brand_status==1?'Active':'Inactive'}} </td>
                            <td> @if($cars->brand_status==0)
                                <a href="{{url('/admin-car-brand-edit/'.$cars->id)}}"
                                   class="btn btn-sm btn-danger "><i class="far fa-thumbs-down"></i></a>
                                   @elseif($cars->brand_status==1)
                                   <a href="{{url('/admin-car-brand-inactive/'.$cars->id)}}"
                                   class="btn btn-sm btn-success "><i class="far fa-thumbs-up"></i></a>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Car Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('addcar.brand')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label">Car Brand Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Car Brand">
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
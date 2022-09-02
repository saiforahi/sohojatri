<?php

namespace App\Http\Controllers\backend;

use DB;
use App\car;
use App\car_brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    public function PendingCar($data = false){
        $car = car::where('status',0)->get();
        if($data){
            $carwas = car::find($data);
            return view('backend.car.pending',compact('car','carwas'));
        }else{
            return view('backend.car.pending',compact('car'));
        }

    }

    public function PendingCarApprove(Request $request){
        $carwas = car::find($request->id);
        $carwas->car_type = $request->type;
        $carwas->status = 1;
        $carwas->save();

        return redirect('admin-approve-car');
    }

    public function ApproveCar($data = false){
        $car = car::where('status',1)->get();
        if($data){
            $carwas = car::find($data);
            return view('backend.car.approve',compact('car','carwas'));
        }else{
            return view('backend.car.approve',compact('car'));
        }

    }

    public function ApproveCarPending(Request $request){
        $carwas = car::find($request->id);
        $carwas->status = 0;
        $carwas->save();

        return redirect('admin-approve-car');
    }
     public function carBrand(){
        $car_brand = car_brand::get();
        return view('backend.car.car_brand',compact('car_brand'));
    }
    public function carBrandAdd(Request $request){
          $car_brand =new car_brand;
          $car_brand->brand_name=$request->brand_name;
          $car_brand->save();
          //dd($car_brand);
          return redirect('/admin-car-brand');
    }
     public function carBrandEdit($id){
        DB::table('car_brands')
        ->where('id',$id)
        ->update(['brand_status'=>1]);
    
        return redirect('/admin-car-brand');
    }
      public function carBrandInactive($id){
        DB::table('car_brands')
        ->where('id',$id)
        ->update(['brand_status'=>0]);
    
        return redirect('/admin-car-brand');
    }

}

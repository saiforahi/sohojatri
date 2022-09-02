<?php

namespace App\Http\Controllers\frontend;

use App\car;
use DB;
use App\car_brand;
use App\reference;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Intervention\Image\Facades\Image;

class SpController extends Controller
{
    public function index()
    {
        return view('frontend.sp_panel.index');
    }

    public function RemoveCar()
    {
        $car = car::where('user_id',Session('userId'))->where('status','=',3)->get();
        $car_brand = car_brand::get();
        return view('frontend.sp_panel.car.remove_car',compact('car','car_brand'));
    }

    public function Car()
    {
        $car = car::where('user_id',Session('userId'))->where('status','!=',3)->get();
        $car_brand = car_brand::get();
        return view('frontend.sp_panel.car.add_car',compact('car','car_brand'));
    }

    public function AddCar(Request $request)
    {
        $request->validate([
            'brand' => 'required|max:15',
            'modal' => 'required|max:191',
            'fuel' => 'required',
            'car_image1' => 'required',
            'car_image2' => 'required',
            'kilometers' => 'required',
            'regYear' => 'required',
            'modelYear' => 'required',
            'car_number' => 'required|unique:cars,number_plate',
        ]);

        $car = new car;
        $car->brand_id = $request->brand;
        $car->model = $request->modal;
        $car->number_plate = $request->car_number;
        /*if ($request->hasFile('car_image1')) {
            $extension = $request->file('car_image1')->getClientOriginalExtension();
            $fileStore3 = rand(10, 100) . time() . "." . $extension;
            $request->file('car_image1')->storeAs('public/car', $fileStore3);
            $car->car_image1 = $fileStore3;
        }*/
        $file = new \stdClass();
            if ($file = $request->file('car_image1')){
            $file_name = $request->brand_id.'_'.date('Ymd') .'_'.time() . '_1.' . $file->getClientOriginalExtension();
            $url = 'public/car/'.$file_name;
            $file->move('public/car', $file_name);
            $image=Image::make('public/car/'.$file_name);
            $image->resize(300,300)->save('public/car/'.$file_name);
            $car->car_image1 = $url;
			}
        /*if ($request->hasFile('car_image2')) {
            $extension = $request->file('car_image2')->getClientOriginalExtension();
            $fileStore3 = rand(10, 100) . time() . "." . $extension;
            $request->file('car_image2')->storeAs('public/car', $fileStore3);
            $car->car_image2 = $fileStore3;
        }*/
        $file = new \stdClass();
            if ($file = $request->file('car_image2')){
            $file_name = $request->brand_id.'_'.date('Ymd') .'_'.time() . '_2.' . $file->getClientOriginalExtension();
            $url = 'public/car/'.$file_name;
            $file->move('public/car', $file_name);
            $image=Image::make('public/car/'.$file_name);
            $image->resize(300,300)->save('public/car/'.$file_name);
            $car->car_image2 = $url;
			}
        $car->fuel = $request->fuel;
        $car->kilometers = $request->kilometers;
        $car->registration_year = $request->regYear;
        $car->model_year = $request->modelYear;
        $car->user_id = Session('userId');
        $car->save();

        Session::flash('message', 'New car add successfully');
        return redirect('/sp-car');
    }

    public function DeleteCar(Request $request)
    {
        if ($request->Delete) {
            $register_user = car::find($request->Delete);
            $register_user->status = 3;
            $register_user->save();

            Session::flash('message', 'Car deleted');
            return redirect('/sp-car');
        }
    }

    public function RestoreCar(Request $request)
    {
        if ($request->Delete) {
            $register_user = car::find($request->Delete);
            $register_user->status = 0;
            $register_user->save();

            Session::flash('message', 'Car RestoreCar');
            return redirect('/sp-car');
        }
    }

    public function Reference()
    {
        $refer = reference::where('user_id',Session('userId'))->get();
      return view('frontend.sp_panel.reference',compact('refer'));
    }

    public function ReferenceAdd(Request $request)
    {
        $request->validate([
            'number' => 'required|max:15',
            'address' => 'required|max:191',
            'profession' => 'required|max:191',
            'name' => 'required|max:191',
        ]);
        $insert = new reference;
        $insert->name = $request->name;
        $insert->profession = $request->profession;
        $insert->address = $request->address;
        $insert->phone = $request->number;
        $insert->user_id = Session('userId');
        $insert->save();

        Session::flash('message', 'Reference add successfully');
        return redirect('sp-reference');
    }
    public function activeCar($id){
        DB::table('cars')
        ->where('id',$id)
        ->update(['status'=>2]);
    
       return redirect('/sp-car');
    }
    public function inactiveCar($id){
        DB::table('cars')
        ->where('id',$id)
        ->update(['status'=>1]);
    
       return redirect('/sp-car');
    }
}

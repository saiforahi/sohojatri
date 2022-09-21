<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\AddCarRequest;
use App\Http\Requests\api\UserUpdateRequest;
use App\Models\User;
use App\Models\car;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    //
    public function user_details_update(UserUpdateRequest $req){
        try{
            if($req->email!=Auth::user()->email){
                User::where('id',Auth::user()->id)->update([
                    'email_verified_at'=>null
                ]);
            }
            $time=strtotime($req->dob);
            $day=date("d",$time);
            $month=date("m",$time);
            $year=date("Y",$time);
            $user=User::where('id',Auth::user()->id)->update(array_merge($req->except('dob','bio'),[
                'day'=>$day,
                'month'=>$month,
                'year'=>$year,
                'profile_general_biography'=>$req->bio
            ]));
            if($user){
                return response()->json([
                    'success' => true,
                    'message'=> 'User details updated',
                    'data'=>$user
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=> 'User update failed',
                ], 500);
            }
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // NID verification post
    public function nid_verify(Request $req){
        $validator=Validator::make($req->all(),[
            'nid'=>'required|string|max:13|min:10',
            'nid_first_page'=> 'required',
            'nid_second_page'=>'required'
        ]);
        if($validator->fails()){                                            //validating general registration rules
            return response()->json(['success'=>false,'errors'=>$validator->errors()], 422);
        }
        try{
            
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // add new car
    public function add_car(AddCarRequest $req){
        try{
            $car = new car();
            $car->brand_id = $req->brand;
            $car->model = $req->model;
            $car->number_plate = $req->car_number;
            $file = new \stdClass();
            if ($file = $req->file('car_image1')){
                $file_name = $req->brand_id.'_'.date('Ymd') .'_'.time() . '_1.' . $file->getClientOriginalExtension();
                $url = 'public/car/'.$file_name;
                $file->move('public/car', $file_name);
                $image=Image::make('public/car/'.$file_name);
                $image->resize(300,300)->save('public/car/'.$file_name);
                $car->car_image1 = $url;
            }
            if ($file = $req->file('car_image2')){
                $file_name = $req->brand_id.'_'.date('Ymd') .'_'.time() . '_2.' . $file->getClientOriginalExtension();
                $url = 'public/car/'.$file_name;
                $file->move('public/car', $file_name);
                $image=Image::make('public/car/'.$file_name);
                $image->resize(300,300)->save('public/car/'.$file_name);
                $car->car_image2 = $url;
            }
            $car->fuel = $req->fuel;
            $car->kilometers = $req->kilometers;
            $car->registration_year = $req->regYear;
            $car->model_year = $req->modelYear;
            $car->user_id = Auth::user()->user_id;
            $car->save();
            return response()->json(['success'=>true,'message'=>'New car added!'], 201);
        }   
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // my cars
    public function my_cars(){
        try{
            $cars=car::with('brand')->where('user_id',Auth::user()->user_id)->get();
            return response()->json(['success'=>true,'message'=>'My cars','data'=>$cars], 200);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // remove user car
    public function remove_car(car $car){
        try{
            if($car->delete()){
                return response()->json(['success'=>true,'message'=>'Your car has been deleted'], 200);
            }
            else{
                return response()->json(['success'=>true,'message'=>'Something went wrong'], 500);
            }
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // mark user car active
    public function mark_car_active(Request $req){
        try{
            $req->validate([
                'car_id'=>'required',
                'status'=>'required|numeric'
            ]);
            car::where('id',$req->car_id)->update([
                'status'=>$req->status
            ]);
            return response()->json(['success'=>true,'message'=>'Status has been updated','data'=>car::findOrFail($req->car_id)], 200);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

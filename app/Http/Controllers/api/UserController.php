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
use App\Http\Helper\CommonHelper;
use App\Models\Validation;
use Illuminate\Support\Facades\Hash;
use App\Models\otp_verify;
use DB;

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
    
    
    public function sendOtpCode(Request $request){
    
        try{
            $otp=random_int(100000, 999999);
            
            DB::table('otp_verifies')->insert(
                ['phone'=>$request->phone, 'otp' => $otp]
            );
            $mobileNo=$request->phone;
            $message='your verification code is'.$otp;
            $response = $this->techno_bulk_sms($mobileNo,$message);
            
            return response()->json(['success'=>true,'message'=>'OTP sent!'],200);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'errors'=>$e->getMessage()], 500);
        }
    }
    
    
    public function verifyOTP(Request $request){
        $validator=Validator::make($request->all(),[
            'otp_code'=>'required|string|max:6|min:6'
        ]);
        if($validator->fails()){                                        
            return response()->json(['success'=>false,'errors'=>$validator->errors()], 422);
        }
        try{
            if(otp_verify::where(['phone'=>$request->phone,'otp'=>$request->otp_code])->exists()){
                $user= User::where('phone',$request->phone)->first();
                DB::table('users')
                    ->where('phone',$user->phone)
                    ->update(['phoneIsVerified' => 1]);
                $token=$user->createToken('api_token')->plainTextToken;
                
                otp_verifies::where(['phone'=>$request->phone,'otp'=>$request->otp_code])->delete();
                return response()->json(['success'=>true,'token'=>$token,'message'=>'OTP verified & User Signed in!',"data"=>$user],200);
            }
            return response()->json(['success'=>false,'message'=>'Invalid code!'],422);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'errors'=>$e->getMessage()], 500);
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
    
    
    function techno_bulk_sms($mobile_no,$message){
        
        
        $ap_key = "175383914514785920230101104227pmlHzCOFKi"; 
        $sender_id='233';
        $user_email='sayiful@gmail.com';
        
    	    $url = 'https://24bulksms.com/24bulksms/api/api-sms-send';
        	$data = array('api_key' => $ap_key,
        	 'sender_id' => $sender_id,
        	 'message' => $message,
        	 'mobile_no' =>$mobile_no,
        	 'user_email'=> $user_email		
        	 );
            
        	// use key 'http' even if you send the request to https://...
        	 $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
            $output = curl_exec($curl);
            curl_close($curl);
        
    }
     
    

    public function ForgotPasswordChange(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|max:20|min:6',
            'confirmed' => 'required|max:20|min:6',
        ]);
        
        $search = user::where('token', $request->token)->first();
        
        if (!empty($search)) {
            $search->password = Hash::make($request->password);
            $search->update();
            
            return response()->json([
                'success' => false,
                'message' => 'Password change successfully',
            ], 200);
            
        } else {
            
            return response()->json([
                'success' => false,
                'message' => 'Something wrong. Please try again later',
            ], 200);
            
        }
    }
    
    
    public function ForgotPasswordPost(Request $request)
    {

        $request->validate([
            'emailOrMobile' => 'required|max:50',
        ]);
        $regMedium = filter_var($request->emailOrMobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $email = $regMedium == 'email' ? $request->emailOrMobile : null;
        $phone = $regMedium == 'email' ? null : $request->emailOrMobile;
        $number = '';
        try {
            $verification_code = CommonHelper::generateOTP(6);
            if ($email) {
                $user = user::where('email', $email)->first();
            }
            if ($phone) {
                $number = $phone;
                if (!$number) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid email and phone number',
                    ], 500);
                }
                $user = user::where('phone', $number)->first();
            }
            if (!empty($user)) {
                
                if ($request->verification_code) {
                    
                    if ($email) {
                        if ($this->checkOtpSent($email) == 0) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Your OTP has been expired..',
                            ], 500);
                        }
                        $search = Validation::where('destination', $email)->where('code', $request->verification_code)->first();
                        if (!$search) {
                            return response()->json([
                                'success' => false,
                                'message' => 'OTP did not match try again..',
                            ], 500);
                        }
                        return response()->json([
                            'success' => true,
                            'message' => 'otp matched successfully',
                            'token' => $user->token
                        ], 200);
                            
                    } else {
                        if ($this->checkOtpSent($number) == 0) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Your OTP has been expired..',
                            ], 500);
                        }
                        $search = Validation::where('destination', $number)->where('code', $request->verification_code)->first();
                        if (!$search) {
                            return response()->json([
                                'success' => false,
                                'message' => 'OTP did not match try again..',
                            ], 500);
                        }
                    }
                    
                } else {
                    
                    if ($email) {
                        $this->sendOTP($email, 'email', $verification_code, $user);
                        $this->saveVerify($email, 'email', $verification_code, $user);
                        
                        return response()->json([
                            'success' => true,
                            'message' => 'verification code sent already to your email',
                        ], 200);
                    } else {
                        $this->sendOTP($number, 'phone', $verification_code, $user);
                        $this->saveVerify($number, 'phone', $verification_code, $user);
                        $message = "Your verification code is ".$verification_code;
                        $sms = $this->techno_bulk_sms($number,$message);
                        
                        return response()->json([
                            'success' => true,
                            'message' => 'verification code sent already to your phone',
                        ], 200);
                    }
                }
            } else
                    return response()->json([
                        'success' => false,
                        'message' => 'Phone or Email not match',
                    ], 500);
        } catch (\Exception $e) {
            
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                    ], 500);
        }
    }


}

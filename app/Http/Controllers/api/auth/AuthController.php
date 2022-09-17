<?php

namespace App\Http\Controllers\api\auth;

use Auth;
use App\Models\User;
use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\VerifyOTP;
use App\Models\Validation;
use App\Models\verification;
use Exception;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected $general_reg_rules=[
        'name' => 'required|string|between:2,100',
        'lname' => 'required|string|between:2,100',
        'email' => 'required|string|email|max:100|unique:users,email',
        "phone" => ['required','regex:/(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/','max:11','min:11','unique:users,phone'],
        'gender' => 'required|string',
        'password' => 'required|string|min:8',
        'dob'=> 'required|date|date_format:Y-m-d|before:today'
    ];
    
    public function __construct() {
        $this->middleware('auth:sanctum', ['except' => ['login','register','verifyOTP','resendOTP']]);
    }
    public function validator($data,$rules){
        return Validator::make($data, $data);
    }
    public function logout(Request $request) {
        $request->user()->tokens()->delete(); //deleting all the tokens
        return response()->json(['success'=>true,'message' => 'User successfully signed out'],201);
    }

    public function user_details() {
        return response()->json(['success'=>true,'data'=>auth()->user()]);
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'errors'=>$validator->errors()], 422);
        }
        try{
            $user=User::where('phone',$request->username)->orWhere('email',$request->username)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect'],
                ]);
            }
            $token=$user->createToken('api_token')->plainTextToken;
            return response()->json(['success'=>true,'token'=>$token,'message'=>'User Signed in!',"data"=>$user],200);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'errors'=>$e->getMessage()], 404);
        }
        
    }
    public function resendOTP(Request $request){
        $validator=Validator::make($request->all(),[
            'user_id'=>'required|exists:users,user_id',
        ]);
        if($validator->fails()){                                            //validating general registration rules
            return response()->json(['success'=>false,'errors'=>$validator->errors()], 422);
        }
        try{
            Validation::where('fk_user_id',$request->user_id)->delete();
            $user=User::where('user_id',$request->user_id)->first();
            $otp=random_int(100000, 999999);
            Validation::create([
                'fk_user_id'=>$request->user_id,
                'destination'=>$user->email,
                'validation_type'=>'email',
                'code'=>$otp
            ]);
            Mail::to($user->email)->send(new VerifyOTP($otp,$user->name));
            return response()->json(['success'=>true,'message'=>'OTP sent!'],200);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'errors'=>$e->getMessage()], 500);
        }
    }
    public function resetPassword(Request $request){
        $validator=Validator::make($request->all(),[
            'old_password'=>'required|min:8',
            'new_password'=>'required|min:8'
        ]);
        if($validator->fails()){                                            //validating general registration rules
            return response()->json(['success'=>false,'errors'=>$validator->errors()], 422);
        }
        try{
            if(Hash::check($request->old_password,FacadesAuth::user()->password)){
                $user=User::findOrFail(FacadesAuth::user()->id);
                $user->password=Hash::make($request->new_password);
                $user->save();
            }
            return response()->json(['success'=>true,'message'=>'Your password has been reset!'],200);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'errors'=>$e->getMessage()], 500);
        }
    }
    public function verifyOTP(Request $request){
        $validator=Validator::make($request->all(),[
            'user_id'=>'required|exists:users,user_id',
            'otp_code'=>'required|string|max:6|min:6'
        ]);
        if($validator->fails()){                                            //validating general registration rules
            return response()->json(['success'=>false,'errors'=>$validator->errors()], 422);
        }
        try{
            if(Validation::where(['fk_user_id'=>$request->user_id,'code'=>$request->otp_code])->exists()){
                Validation::where(['fk_user_id'=>$request->user_id,'code'=>$request->otp_code])->delete();
                User::where('user_id',$request->user_id)->update([
                    'email_verified_at'=> date("Y-m-d H:i:s")
                ]);
                $verification=verification::updateOrCreate(['user_id'=>Auth::user()->user_id],['email'=>1]);
                return response()->json(['success'=>true,'message'=>'OTP Verified!'],200);
            }
            return response()->json(['success'=>false,'message'=>'Invalid code!'],422);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'errors'=>$e->getMessage()], 500);
        }
    }
    public function register(Request $request) {
        $validator=Validator::make($request->all(),$this->general_reg_rules);
        if($validator->fails()){                                            //validating general registration rules
            return response()->json(['success'=>false,'errors'=>$validator->errors()], 422);
        }

        try{
            //date of birth extraction
            $time=strtotime($request->dob);
            $day=date("d",$time);
            $month=date("m",$time);
            $year=date("Y",$time);
            //extraction ends
            $user = User::create(array_merge($request->except('dob'),[
                'day'=>$day,
                'month'=>$month,
                'year'=>$year,
                'password' => bcrypt($request->password),
                'user_id'=>date('Y').date('m').date('d').User::all()->count()
            ]));
            if($request->hasFile('image') && $request->file('image')->isValid()){
                $file = new \stdClass();
                if ($file = $request->file('image')) {
                    $file_name = date('Ymd') . '_' . time() . '_1.' . $file->getClientOriginalExtension();
                    $url = 'public/user/' . $file_name;
                    $file->move('public/user', $file_name);
                    $image = Image::make('public/user/' . $file_name);
                    $image->resize(300, 300)->save('public/user/' . $file_name);
                    $user->image = $url;
                    //dd($user);
                }
            }
            $user->save();
            $validation=Validation::create([
                'fk_user_id'=>$user->user_id,
                'destination'=>$user->email,
                'validation_type'=>'email',
                'code'=>random_int(100000, 999999)
            ]);
            // Mail::to($user->email)->send(new VerifyOTP($validation->code,$user->name));
            
            return response()->json([
                'success' => true,
                'message'=> 'Registration Successful',
                'data' => $user,
            ], 201);
        }
        catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

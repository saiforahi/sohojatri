<?php

namespace App\Http\Controllers\api\auth;

use Auth;
use App\Models\User;
use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    protected $general_reg_rules=[
        'name' => 'required|string|between:2,100',
        'lname' => 'required|string|between:2,100',
        'email' => 'required|string|email|max:100',
        "phone" => ['required','regex:/(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/','max:11','min:11'],
        'day' => 'required|string',
        'month' => 'required|string',
        'year' => 'required|string',
        'gender' => 'required|string',
        'password' => 'required|string|min:8',
    ];
    
    public function __construct() {
        $this->middleware('auth:sanctum', ['except' => ['login','register']]);
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

    public function register(Request $request) {
        $validator=Validator::make($request->all(),$this->general_reg_rules);
        if($validator->fails()){                                            //validating general registration rules
            return response()->json(['success'=>false,'errors'=>$validator->errors()], 422);
        }

        try{
            $user = User::create(array_merge($validator->validated(),['password' => bcrypt($request->password),'user_id'=>date('Y').date('m').date('d').User::all()->count()]));
            // $user->password=Hash::make($request->passowrd);
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
            return response()->json([
                'success' => true,
                'message'=> 'Registration Successful',
                'data' => $user,
            ], 201);
        }
        catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'User registration failed!',
            ], 500);
        }
    }
}

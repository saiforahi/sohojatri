<?php

namespace App\Http\Controllers;

use App\Http\Helper\CommonHelper;
use App\Models\landing_image;
use App\Models\popular_ride;
use App\Models\stopover;
use App\Models\User;
use App\Models\Validation;
use App\Models\verification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use DateTime;

class homeController extends Controller
{
    public function homepage()
    {

        $landingPage = landing_image::where('approve', 1)->first();
        if ($landingPage) {
            $landingPage = $landingPage->image;
        } else {
            $landingPage = false;
        }

        $popular = popular_ride::limit(3)->get();
        $rides = stopover::where('date', '>=', date("m/d/Y"))->limit(10)->get();
        return view('frontend.index', compact('landingPage', 'rides', 'popular'));
    }

    public function UserLogin(Request $request)
    {
        $request->validate([
            'emailOrMobile' => 'required',
            'password' => 'required|max:20|min:6',
        ]);
        $regMedium = filter_var($request->emailOrMobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $email = $regMedium == 'email' ? $request->emailOrMobile : null;
        $phone = $regMedium == 'email' ? null : $request->emailOrMobile;
        
        try {
            if ($email) {
                $user = User::where('email', $email)->first();
            }
            if ($phone) {
                $number = $this->phone_number($phone);
                if ($number==false) {
                    return redirect()->back()->withErrors(['Invalid email and phone number']);
                }
                $user = User::where('phone', $number)->first();
            }
            
            if (!empty($user)) {
                if ($user && Hash::check($request->password, $user->password)) {
                    $user->token = $user->createToken('api_token')->plainTextToken;
                    $user->logincount += 1;
                    if ($request->remember_me) {
                        setcookie('userId', $user->user_id, time() + (86400 * 30), "/");
                        setcookie('token', $user->token, time() + (86400 * 30), "/");
                        Session::put('token', $user->token);
                        Session::put('userId', $user->user_id);
                    } else {
                        Session::put('token', $user->token);
                        Session::put('userId', $user->user_id);
                        $user->update();
                    }
                    return redirect('/');
                } else {
                    return redirect()->back()->withErrors(['Wrong password try again']);
                }
            } else {
                return redirect()->back()->withErrors(['Phone or Email not match']);
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    public function UserRegister(Request $request)
    {
        $request->validate([
            'emailOrMobile' => 'required|max:50',
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'day' => 'required|max:191',
            'month' => 'required|max:191',
            'year' => 'required|max:191',
            'gender' => 'required',
            'password' => 'required|max:20|min:6',
        ]);
        $regMedium = filter_var($request->emailOrMobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $email = $regMedium == 'email' ? $request->emailOrMobile : null;
        $phone = $regMedium == 'email' ? null : $request->emailOrMobile;
        $userId = time();
        try {
            $user = new User;
            if ($email) {
                $check = User::where('email', $email)->first();
                if ($check) {
                    return redirect()->back()->withErrors(['This email already used try another']);
                } else $user->email = $email;
            }

            if ($phone) {
                $number = $this->phone_number($phone);
                if (!$number) {
                    return redirect()->back()->withErrors(['Invalid email and phone number']);
                }

                $check = User::where('phone', $phone)->first();
                if ($check) {
                    return redirect()->back()->withErrors(['This number already used try another']);
                } else $user->phone = $number;
            }

            $user->name = $request->first_name;
            $user->lname = $request->last_name;
            $user->day = $request->day;
            $user->month = $request->month;
            $user->year = $request->year;
            $user->user_id = $userId;
            $user->gender = $request->gender;
            $user->image = \URL::to('') . '/images/admin.jpg';
            $user->password = Hash::make($request->password);
            $user->token = $request->_token;
            $user->save();

            Session::put('token', $request->_token);
            Session::put('userId', $userId);
            return redirect('/sp-verification');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookDataDeletion(){
        $user = Socialite::driver('facebook')->user();
        $reg_user = User::where('facebook_id', $user->getId())->first();
        if ($reg_user) {
            $reg_user->facebook_id = "";
            $reg_user->save();
            return "User data deletion successfully";
        } else {
            return "User Not found";
        }
    }


    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        if (Session::get('userId') != null) {
            $account = User::where('user_id', Session('userId'))->first();
            $account->facebook_id = $user->getId();
            $account->save();
            return redirect('sp-verification');
        } else {
            $reg_user = User::where('facebook_id', $user->getId())->first();
            if ($reg_user) {
                Session::put('token', $reg_user->token);
                Session::put('userId', $reg_user->user_id);
                return redirect('/');
            } else {
                $userId = time();
                $usernew = new User();
                $usernew->name = $user->getName();
                $usernew->user_id = $userId;
                $usernew->image = $user->getAvatar();
                $usernew->facebook_id = $user->getId();
                $usernew->token = $user->token;
                $usernew->email = $user->getEmail();
                $usernew->email_verified_at = date("Y-m-d H:i:s");
                $usernew->save();

                Session::put('token', $user->token);
                Session::put('userId', $userId);
                return redirect('/sp-verification');
            }
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $reg_user = User::where('email', $user->getEmail())->first();
        if ($reg_user) {
            Session::put('token', $reg_user->token);
            Session::put('userId', $reg_user->user_id);
            return redirect('/');
        } else {
            $userId = time();
            $usernew = new User();
            $usernew->name = $user->getName();
            $usernew->user_id = $userId;
            $usernew->image = $user->getAvatar();
            $usernew->token = $user->token;
            $usernew->email = $user->getEmail();
            $usernew->email_verified_at = date("Y-m-d H:i:s");
            $usernew->save();

            Session::put('token', $user->token);
            Session::put('userId', $userId);
            return redirect('/sp-verification');
        }
    }


    public function language(Request $request)
    {
        if (!\Session::has('locale')) {
            \Session::put('locale', $request->lng);
        } else {
            Session::put('locale', $request->lng);
        }

        return Redirect::back();
    }

    public function ForgotPassword()
    {
        return view('frontend.log_in.forget_password');
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
                $user = User::where('email', $email)->first();
            }
            if ($phone) {
                $number = $this->phone_number($phone);
                if (!$number) {
                    return redirect()->back()->withErrors(['Invalid email and phone number']);
                }
                $user = User::where('phone', $number)->first();
            }
            if (!empty($user)) {
                if ($request->verification_code) {
                    if ($email) {
                        if ($this->checkOtpSent($email) == 0) {
                            return redirect()->back()->withErrors(['Your OTP has been expired..']);
                        }
                        $search = Validation::where('destination', $email)->where('code', $request->verification_code)->first();
                        if (!$search) {
                            return view('frontend.log_in.forget_password', ['destination' => $request->emailOrMobile])->withErrors(['OTP did not match try again..']);
                        }
                    } else {
                        if ($this->checkOtpSent($number) == 0) {
                            return redirect()->back()->withErrors(['Your OTP has been expired..']);
                        }
                        $search = Validation::where('destination', $number)->where('code', $request->verification_code)->first();
                        if (!$search) {
                            return view('frontend.log_in.forget_password', ['destination' => $request->emailOrMobile])->withErrors(['OTP did not match try again..']);
                        }
                    }
                    return view('frontend.log_in.forget_password', ['user' => $user]);
                } else {
                    if ($email) {
                        $this->sendOTP($email, 'email', $verification_code, $user);
                        $this->saveVerify($email, 'email', $verification_code, $user);
                    } else {
                        $this->sendOTP($number, 'phone', $verification_code, $user);
                        $this->saveVerify($number, 'phone', $verification_code, $user);
                    }
                    return view('frontend.log_in.forget_password', ['destination' => $request->emailOrMobile]);
                }
            } else return redirect()->back()->withErrors(['Phone or Email not match']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }


    public function ForgotPasswordChange(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'token' => 'required',
            'id' => 'required',
            'password' => 'required|max:20|min:6',
            'confirmed' => 'required|max:20|min:6',
        ]);
        $search = User::where('user_id', $request->user_id)->where('id', $request->id)->where('token', $request->token)->first();
        if (!empty($search)) {
            $search->password = Hash::make($request->password);
            $search->update();
            $request->session()->flash('message', 'Password change successfully');
            return redirect('/login');
        } else {
            return redirect()->back()->withErrors(['Something wrong. Please try again later']);
        }
    }

    public function LogoutUser()
    {
        $user=User::where('user_id',Session::get('userId'))->first();
        $user->tokens()->delete();
        $user->token=null;
        $user->save();
        Session::forget('token');
        Session::forget('userId');
        
        setcookie('userId', '', time() - 3600);
        setcookie('token', '', time() - 3600);
        return redirect('/');

    }

    public function UserReg(Request $request)
    {
        $d = $request->all();
        if (!is_numeric($request->get('mobile-or-email'))) {
            echo "hi";
        } else
            echo "no";
        //dd($d);
        return "";
    }
}

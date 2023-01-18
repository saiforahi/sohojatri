<?php

namespace App\Http\Controllers\frontend;

use App\Http\Helper\CommonHelper;
use App\Models\User;
use App\Models\Validation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\verification;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;

class VerificationController extends Controller
{
    public function SpVerification()
    {

        $verification = verification::where('user_id', Session('userId'))->first();
        $user = user::where('user_id', Session('userId'))->first();
        if (!$verification) {
            $verification = new verification;
            $verification->user_id = Session('userId');
            $verification->save();
        }
        return view('frontend.sp_panel.profile.verification', compact('verification', 'user'));
    }

    public function SpVerificationPost(Request $request)
    {
        $verification = verification::where('user_id', Session('userId'))->first();
        if ($request->submit == "nid") {

            $request->validate([
                'nid' => 'required',
                'nidImage1' => 'required',
                'nidImage2' => 'required',
            ]);
            $verification->nid = $request->nid;

            $file = new \stdClass();
            if ($file = $request->file('nidImage1')) {
                $file_name = $request->nid . '_' . date('Ymd') . '_' . time() . '_1.' . $file->getClientOriginalExtension();
                $url = 'public/nid/' . $file_name;
                $file->move('public/nid', $file_name);
                $image = Image::make('public/nid/' . $file_name);
                $image->resize(300, 300)->save('public/nid/' . $file_name);
                $verification->nid_image1 = $url;
                //dd($verification);
            }

            $file = new \stdClass();
            if ($file = $request->file('nidImage2')) {
                $file_name = $request->nid . '_' . date('Ymd') . '_' . time() . '_2.' . $file->getClientOriginalExtension();
                $url = 'public/nid/' . $file_name;
                $file->move('public/nid', $file_name);
                $image = Image::make('public/nid/' . $file_name);
                $image->resize(300, 300)->save('public/nid/' . $file_name);
                $verification->nid_image2 = $url;
            }
            // dd($verification);
            $verification->nid_status = 0;
            $verification->save();
        } elseif ($request->submit == "passport") {
            $request->validate([
                'passport' => 'required',
                'passportImage1' => 'required',
                'passportImage2' => 'required',
            ]);
            $verification->passport = $request->passport;

            $file = new \stdClass();
            if ($file = $request->file('passportImage1')) {
                $file_name = $request->passport . '_' . date('Ymd') . '_' . time() . '_1.' . $file->getClientOriginalExtension();
                $url = 'public/passport/' . $file_name;
                $file->move('public/passport', $file_name);
                $image = Image::make('public/passport/' . $file_name);
                $image->resize(300, 300)->save('public/passport/' . $file_name);
                $verification->passport_image1 = $url;
                //dd($verification);
            }
            $file = new \stdClass();
            if ($file = $request->file('passportImage2')) {
                $file_name = $request->passport . '_' . date('Ymd') . '_' . time() . '_2.' . $file->getClientOriginalExtension();
                $url = 'public/passport/' . $file_name;
                $file->move('public/passport', $file_name);
                $image = Image::make('public/passport/' . $file_name);
                $image->resize(300, 300)->save('public/passport/' . $file_name);
                $verification->passport_image2 = $url;
                //dd($verification);
            }
            $verification->passport_status = 0;

            $verification->save();
        } elseif ($request->submit == "driving") {
            $request->validate([
                'driving' => 'required',
                'drivingImage1' => 'required',
                'drivingImage2' => 'required',
            ]);
            $verification->driving = $request->driving;
            $file = new \stdClass();
            if ($file = $request->file('drivingImage1')) {
                $file_name = $request->driving . '_' . date('Ymd') . '_' . time() . '_1.' . $file->getClientOriginalExtension();
                $url = 'public/driving/' . $file_name;
                $file->move('public/driving', $file_name);
                $image = Image::make('public/driving/' . $file_name);
                $image->resize(300, 300)->save('public/driving/' . $file_name);
                $verification->driving_image1 = $url;
                //dd($verification);
            }

            $file = new \stdClass();
            if ($file = $request->file('drivingImage2')) {
                $file_name = $request->driving . '_' . date('Ymd') . '_' . time() . '_2.' . $file->getClientOriginalExtension();
                $url = 'public/driving/' . $file_name;
                $file->move('public/driving', $file_name);
                $image = Image::make('public/driving/' . $file_name);
                $image->resize(300, 300)->save('public/driving/' . $file_name);
                $verification->driving_image2 = $url;
                //dd($verification);
            }
            //dd($verification);
            $verification->driving_status = 0;
            $verification->save();
        } elseif ($request->submit == "email") {
            $request->validate([
                'email' => 'required|email|max:30',
            ]);
            $email = $request->email;
            $user = user::where('email', $email)->where('user_id', '!=', Session('userId'))->first();
            if (empty($user)) {
                $account = user::where('user_id', Session('userId'))->first();
                if ($request->verification_code) {
                    if ($this->checkOtpSent($email) == 0) {
                        return redirect()->back()->withErrors(['Your OTP has been expired..']);
                    }
                    $search = Validation::where('destination', $email)->where('code', $request->verification_code)->first();
                    if (!$search) {
                        return view('frontend.sp_panel.profile.verify', ['destination' => $email, 'type' => 'email'])->withErrors(['OTP did not match try again..']);
                    }
                    $search->delete();
                    $account->email = $email;
                    $account->email_verified_at = date("Y-m-d H:i:s");
                    $account->save();
                    return redirect('sp-verification');
                }
                $verification_code = CommonHelper::generateOTP(6);
                $this->sendOTP($email, 'email', $verification_code, $account);
                $this->saveVerify($email, 'email', $verification_code, $account);
                return view('frontend.sp_panel.profile.verify', ['destination' => $email, 'type' => 'email']);
            } else return redirect()->back()->withErrors(['This email already used to create account.']);
        } elseif ($request->submit == "phone") {
            $request->validate([
                'phone' => 'required|max:14',
            ]);
            $phone = $request->phone;
            $number = $this->phone_number($phone);
            if (!$number) {
                return redirect()->back()->withErrors(['Invalid phone number']);
            }
            $user = user::where('phone', $number)->where('user_id', '!=', Session('userId'))->first();
            if (empty($user)) {
                $account = user::where('user_id', Session('userId'))->first();
                if ($request->verification_code) {
                    if ($this->checkOtpSent($number) == 0) {
                        return redirect()->back()->withErrors(['Your OTP has been expired..']);
                    }
                    $search = Validation::where('destination', $number)->where('code', $request->verification_code)->first();
                    if (!$search) {
                        return view('frontend.sp_panel.profile.verify', ['destination' => $number, 'type' => 'phone'])->withErrors(['OTP did not match try again..']);
                    }
                    $search->delete();
                    $account->phone = $number;
                    $account->phone_verified_at = date('d-m-y h:i:s');
                    $account->save();
                    return redirect('sp-verification');
                }
                $verification_code = CommonHelper::generateOTP(6);
                $this->sendOTP($number, 'phone', $verification_code, $account);
                $this->saveVerify($number, 'phone', $verification_code, $account);
                return view('frontend.sp_panel.profile.verify', ['destination' => $number, 'type' => 'phone']);
            } else return redirect()->back()->withErrors(['This email already used to create account.']);
        } else {
            echo "Something Wrong";
        }

        return redirect('sp-verification');
    }

    public function SpVerificationPost_API(Request $request)
    {
        $verification = verification::where('user_id', Auth::user()->user_id)->first();
        if(!$verification){
            $verification=Verification::create(['user_id'=>Auth::user()->user_id]);
        }
        if ($request->type == "nid") {
            $request->validate([
                'nid' => 'required',
                'nidImage1' => 'required',
                'nidImage2' => 'required',
            ]);
            $verification->nid = $request->nid;

            $file = new \stdClass();
            if ($file = $request->file('nidImage1')) {
                $file_name = $request->nid . '_' . date('Ymd') . '_' . time() . '_1.' . $file->getClientOriginalExtension();
                $url = 'public/nid/' . $file_name;
                $file->move('public/nid', $file_name);
                $image = Image::make('public/nid/' . $file_name);
                $image->resize(300, 300)->save('public/nid/' . $file_name);
                $verification->nid_image1 = $url;
                //dd($verification);
            }

            $file = new \stdClass();
            if ($file = $request->file('nidImage2')) {
                $file_name = $request->nid . '_' . date('Ymd') . '_' . time() . '_2.' . $file->getClientOriginalExtension();
                $url = 'public/nid/' . $file_name;
                $file->move('public/nid', $file_name);
                $image = Image::make('public/nid/' . $file_name);
                $image->resize(300, 300)->save('public/nid/' . $file_name);
                $verification->nid_image2 = $url;
            }
            // dd($verification);
            $verification->nid_status = 0;
            $verification->save();
            return response()->json(['success'=>true,'message'=>"Request submitted"],200);
        } elseif ($request->type == "passport") {
            $request->validate([
                'passport' => 'required',
                'passportImage1' => 'required',
                'passportImage2' => 'required',
            ]);
            $verification->passport = $request->passport;

            $file = new \stdClass();
            if ($file = $request->file('passportImage1')) {
                $file_name = $request->passport . '_' . date('Ymd') . '_' . time() . '_1.' . $file->getClientOriginalExtension();
                $url = 'public/passport/' . $file_name;
                $file->move('public/passport', $file_name);
                $image = Image::make('public/passport/' . $file_name);
                $image->resize(300, 300)->save('public/passport/' . $file_name);
                $verification->passport_image1 = $url;
                //dd($verification);
            }
            $file = new \stdClass();
            if ($file = $request->file('passportImage2')) {
                $file_name = $request->passport . '_' . date('Ymd') . '_' . time() . '_2.' . $file->getClientOriginalExtension();
                $url = 'public/passport/' . $file_name;
                $file->move('public/passport', $file_name);
                $image = Image::make('public/passport/' . $file_name);
                $image->resize(300, 300)->save('public/passport/' . $file_name);
                $verification->passport_image2 = $url;
                //dd($verification);
            }
            $verification->passport_status = 0;
            $verification->save();
            return response()->json(['success'=>true,'message'=>"Request submitted"],200);
        } elseif ($request->type == "driving") {
            $request->validate([
                'driving' => 'required',
                'drivingImage1' => 'required',
                'drivingImage2' => 'required',
            ]);
            $verification->driving = $request->driving;
            $file = new \stdClass();
            if ($file = $request->file('drivingImage1')) {
                $file_name = $request->driving . '_' . date('Ymd') . '_' . time() . '_1.' . $file->getClientOriginalExtension();
                $url = 'public/driving/' . $file_name;
                $file->move('public/driving', $file_name);
                $image = Image::make('public/driving/' . $file_name);
                $image->resize(300, 300)->save('public/driving/' . $file_name);
                $verification->driving_image1 = $url;
                //dd($verification);
            }

            $file = new \stdClass();
            if ($file = $request->file('drivingImage2')) {
                $file_name = $request->driving . '_' . date('Ymd') . '_' . time() . '_2.' . $file->getClientOriginalExtension();
                $url = 'public/driving/' . $file_name;
                $file->move('public/driving', $file_name);
                $image = Image::make('public/driving/' . $file_name);
                $image->resize(300, 300)->save('public/driving/' . $file_name);
                $verification->driving_image2 = $url;
                //dd($verification);
            }
            //dd($verification);
            $verification->driving_status = 0;
            $verification->save();
            return response()->json(['success'=>true,'message'=>"Request submitted"],200);
        } elseif ($request->submit == "email") {
            $request->validate([
                'email' => 'required|email|max:30',
            ]);
            $email = $request->email;
            $user = user::where('email', $email)->where('user_id', '!=', Auth::user()->user_id)->first();
            if (empty($user)) {
                $account = user::where('user_id', Auth::user()->user_id)->first();
                if ($request->verification_code) {
                    if ($this->checkOtpSent($email) == 0) {
                        return redirect()->back()->withErrors(['Your OTP has been expired..']);
                    }
                    $search = Validation::where('destination', $email)->where('code', $request->verification_code)->first();
                    if (!$search) {
                        return view('frontend.sp_panel.profile.verify', ['destination' => $email, 'type' => 'email'])->withErrors(['OTP did not match try again..']);
                    }
                    $search->delete();
                    $account->email = $email;
                    $account->email_verified_at = date("Y-m-d H:i:s");
                    $account->save();
                    return redirect('sp-verification');
                }
                $verification_code = CommonHelper::generateOTP(6);
                $this->sendOTP($email, 'email', $verification_code, $account);
                $this->saveVerify($email, 'email', $verification_code, $account);
                return view('frontend.sp_panel.profile.verify', ['destination' => $email, 'type' => 'email']);
            } else return redirect()->back()->withErrors(['This email already used to create account.']);
        } elseif ($request->submit == "phone") {
            $request->validate([
                'phone' => 'required|max:14',
            ]);
            $phone = $request->phone;
            $number = $this->phone_number($phone);
            if (!$number) {
                return redirect()->back()->withErrors(['Invalid phone number']);
            }
            $user = user::where('phone', $number)->where('user_id', '!=', Auth::user()->user_id)->first();
            if (empty($user)) {
                $account = user::where('user_id', Auth::user()->user_id)->first();
                if ($request->verification_code) {
                    if ($this->checkOtpSent($number) == 0) {
                        return redirect()->back()->withErrors(['Your OTP has been expired..']);
                    }
                    $search = Validation::where('destination', $number)->where('code', $request->verification_code)->first();
                    if (!$search) {
                        return view('frontend.sp_panel.profile.verify', ['destination' => $number, 'type' => 'phone'])->withErrors(['OTP did not match try again..']);
                    }
                    $search->delete();
                    $account->phone = $number;
                    $account->phone_verified_at = date('d-m-y h:i:s');
                    $account->save();
                    return redirect('sp-verification');
                }
                $verification_code = CommonHelper::generateOTP(6);
                $this->sendOTP($number, 'phone', $verification_code, $account);
                $this->saveVerify($number, 'phone', $verification_code, $account);
                return view('frontend.sp_panel.profile.verify', ['destination' => $number, 'type' => 'phone']);
            } else return redirect()->back()->withErrors(['This email already used to create account.']);
        } else {
            return response()->json(['success'=>false,'message'=>"Invalid request"],404);
        }

        return response()->json(['success'=>false,'message'=>"Something went wrong!"],500);
    }
}

<?php

namespace App\Http\Controllers\backend;

use App\Models\admin_panel;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\car;
use App\Models\stopover;
use App\Models\car_brand;

class adminController extends Controller
{
    public function home()
    {
        $data = admin_panel::all()->count();
        if ($data > 0) {
            if (Session::get('email') != null) {
                return redirect('/dashboard');
            } else {
                return view('backend.login');
            }
        } else {
            return view('backend.register');
        }
    }

    public function LoginCheck(Request $request)
    {
        $admin = admin_panel::where('email', $request->email)
            ->first();

        if (!empty($admin)) {
            if ($admin && Hash::check($request->password, $admin->password)) {
                Session::put('email', $request->email);
                Session::put('name', $admin->name);
                return redirect('/dashboard');
            } else {
                $request->session()->flash('login_error', 'password not match');
                return redirect('/admin');
            }
        } else {
            $request->session()->flash('login_error', 'User name not match');
            return redirect('/admin');
        }
    }

    public function AdminUserRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:16',
        ]);
        if ($validator->fails()) {
            return redirect('/admin')
                ->withErrors($validator)
                ->withInput();
        } else {
            $register_user = new admin_panel;
            $register_user->name = $request->name;
            $register_user->email = $request->email;
            $register_user->password = Hash::make($request->password);
            $register_user->save();
        }
        Session::put('name', $request->name);
        Session::put('email', $request->email);
        return redirect('/dashboard');
    }

    public function dashboard()
    {
        $car_apporved = car::where('status',1)->count();
        $car_pending = car::where('status',0)->count();
        $complete_book = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->where('stopovers.status', 1)->orderBy('stopovers.date', 'desc')->count();
        $partial_book = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->where('stopovers.status', 1)->orderBy('stopovers.date', 'desc')->count();
        $not_book = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->whereIn('stopovers.status', [0, 1])->orderBy('stopovers.date', 'desc')->count();
        $on_going_booked = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->where('stopovers.date', '>=', date("m/d/Y"))->orderBy('stopovers.date', 'desc')->count();
        $total_complete_ride = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->where('stopovers.date', '<', date("m/d/Y"))->whereNotIn('stopovers.status', [0, 1])->orderBy('stopovers.date', 'desc')->count();
        $total_booking_list = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->orderBy('stopovers.date', 'desc')->count();
        $car_brand = car_brand::count();
        
        return view('backend.index',compact('car_apporved','car_pending','complete_book','partial_book','not_book','on_going_booked','total_complete_ride','total_booking_list','car_brand'));
    }


    public function Logout()
    {
        Session::forget('email');
        Session::flush();
        return redirect('/admin');
    }
}

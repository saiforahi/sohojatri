<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\Hash;

use App\Models\close_account;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Intervention\Image\Facades\Image;
use App\Models\rejectphoto;
use App;
use Illuminate\Support\Facades\Session as FacadesSession;

class SpAccountController extends Controller
{
    public function Profile()
    {
        $user = user::where('user_id', Session('userId'))->first();
        return view('frontend.sp_panel.profile.personal_information', compact('user'));
    }

    public function PasswordIndex()
    {
        return view('frontend.sp_panel.profile.password_change');
    }

    public function PasswordChange(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|max:20|min:6',
            'new_confirm_password' => 'same:new_password',
        ]);
        $account = user::where('user_id', Session('userId'))->first();
        if (Hash::check($request->current_password, $account->password)) {
            $account->password = Hash::make($request->new_password);
            $account->save();
            FacadesSession::flash('message', 'Password change successfully');
            return redirect('sp-account-password');
        } else return redirect()->back()->withErrors(['Your password is incorrect..']);
    }

    public function ProfileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191',
            //'dob' => 'required',
        ]);
        $user = user::where('user_id', Session('userId'))->first();
        $user->name = $request->name;
        $user->lname = $request->lname;
        $user->email = $request->email;
        //$user->dob = $request->dob;
        $user->day = $request->day;
        $user->month = $request->month;
        $user->year = $request->year;
        $user->profile_general_biography = $request->profile_general_biography;
        if ($user->phone == "") {
            $user->phone = $request->phone;
        }
        $user->save();

        FacadesSession::flash('message', 'Account update successfully');
        return redirect('sp-account-profile');

    }

    public function Photo()
    {
        return view('frontend.sp_panel.profile.photo');
    }

    public function PhotoStore(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);
        $user = user::where('user_id', Session('userId'))->first();
        /* if ($request->hasFile('image')) {
             $extension = $request->file('image')->getClientOriginalExtension();
             $fileStore3 = rand(10, 100) . time() . "." . $extension;
             $request->file('image')->storeAs('public/user', $fileStore3);
             $user->image = \URL::to('').'/storage/user/'.$fileStore3;
         }*/

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
        $user->save();

        FacadesSession::flash('message', 'Photo upload successfully');
        return redirect('sp-account-photo');

    }

    public function SpAccountClose()
    {
        return view('frontend.sp_panel.profile.account_close');
    }

    public function SpAccountCloseDone(request $request)
    {
        $request->validate([
            'reason' => 'required',
            'recommend' => 'required',
            'improve' => 'required',
        ]);

        $insert = new close_account;
        $insert->reason = $request->reason;
        $insert->recommend = $request->recommend;
        $insert->improve = $request->improve;
        $insert->user_id = Session('userId');
        $insert->save();

        FacadesSession::flash('message', 'Account will be close');
        return redirect('sp-account-close');
    }

    public function rejectPhoto(Request $request)
    {
        $reject = new rejectphoto;
        $reject->reject_photo = $request->reject_photo;
        //dd($reject);


        $reject->save();
        return back();

    }
}

<?php

namespace App\Http\Controllers\backend;

use App\Models\verification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\user;
use App\Models\rejectphoto;
use App\Models\rejectReason;

class VerificationController extends Controller
{
    public function PendingVerification($id = false,$type = false){
      
        $verification = verification::get();
         $rejectmessage = rejectReason::all();
        $result_arr = [];
        $i=0;
        foreach ($verification as $key => $value) {
            $existing_arr = [];
            $k=0;
            if($value->nid_status==1) $existing_arr[$k++] ='NID';
            if($value->passport_status==1) $existing_arr[$k++] ='Passport';
            if($value->driving_status==1) $existing_arr[$k++] = 'Driving';
            $existing = implode(',',$existing_arr);
            
          if($value->nid_status==0 ){
          $result_arr[$i++]=(object) array(
                              "id" => $value->id,
                              "nid" =>  $value->nid,
                              "nid_image1" =>  $value->nid_image1,
                              "nid_image2" =>  $value->nid_image2,
                              "nid_status" =>  $value->nid_status,
                              "email" =>  $value->email,
                              "phone" =>  $value->phone,
                              "user_id" =>  $value->user_id,
                              "created_at" =>  $value->created_at,
                              "updated_at" =>  $value->updated_at,
                              "type" => 'n',
                              "existing"=> $existing
                            );}
          if($value->passport_status==0){
          $result_arr[$i++]= (object) array(
            
                              "id" => $value->id,
                              "passport" => $value->passport,
                              "passport_image1" => $value->passport_image1,
                              "passport_image2" => $value->passport_image2,
                              "passport_status" => $value->passport_status,
                              "email" => $value->email,
                              "phone" => $value->phone,
                              "user_id" => $value->user_id,
                              "created_at" => $value->created_at,
                              "updated_at" =>$value->updated_at,
                              "type" => 'p',
                              "existing"=> $existing
                            );}
          if($value->driving_status==0){
          $result_arr[$i++] = (object) array(
                                "id" => $value->id,
                                "driving" => $value->driving,
                                "driving_image1" => $value->driving_image1,
                                "driving_image2" => $value->driving_image2,
                                "driving_status" => $value->driving_status,
                                "email" => $value->email,
                                "phone" => $value->phone,
                                "user_id" => $value->user_id,
                                "created_at" => $value->created_at,
                                "updated_at" =>$value->updated_at,
                                "type" => 'd',
                                "existing"=> $existing
                              );}
        }
// echo'<pre>'; print_r($result_arr); exit();
        if($id){
            $verifications = verification::find($id);
            $existing_arr = [];
            $k=0;
            if($verifications->nid_status==1) $existing_arr[$k++] ='NID';
            if($verifications->passport_status==1) $existing_arr[$k++] ='Passport';
            if($verifications->driving_status==1) $existing_arr[$k++] = 'Driving';
            $existing2 = implode(',',$existing_arr);
            $verifications->existing = $existing2;
            return view('backend.verification.pending_verification',compact('result_arr','verifications','type','rejectmessage'));
        }else{
            return view('backend.verification.pending_verification',compact('result_arr'));
        }

    }
    /*public function PendingVerification()
    {{{route('admin.pending.car').'/'.$verification->id}}
        $verification = verification::all();
        return view('backend.verification.pending', compact('verification'));
    }*/

    public function PendingVerificationChange(Request $request)
    {  //dd($request->all());
        $insert = verification::find($request->id);

        if ($request->btn_s == "app") {
            if ($request->type == "n") {
                $insert->nid_status = 1;
            } elseif ($request->type == "p") {
                $insert->passport_status = 1;
            } else {
                $insert->driving_status = 1;
            }
        } else {

            if ($request->type == "n") {
                $insert->nid_status = 2;
            } elseif ($request->type == "p") {
                $insert->passport_status = 2;
            } else {
                $insert->driving_status = 2;
            }
             $insert->rejected_message =$request->cbo_rej_mess;
             //dd($insert);
        }

        $insert->save();

        return redirect('admin-pending-verification');
    }

    public function ApproveVerification($data=false)
    {
        //$verification = verification::all();
       $verification = verification::where('nid_status',1)
           ->orWhere('passport_status',1)
           ->orWhere('driving_status',1)
           ->get();
        
        foreach ($verification as $key => $value) {
          $existing_arr = [];
          $k=0;
          if($value->nid_status==1) $existing_arr[$k++] ='NID';
          if($value->passport_status==1) $existing_arr[$k++] ='Passport';
          if($value->driving_status==1) $existing_arr[$k++] = 'Driving';
          $verification[$key]->existing_mess = implode(',',$existing_arr);
        }
        
          if($data){
             $verifications = verification::find($data);
             $existing_arr = [];
            $k=0;
            if($verifications->nid_status==1) $existing_arr[$k++] ='NID';
            if($verifications->passport_status==1) $existing_arr[$k++] ='Passport';
            if($verifications->driving_status==1) $existing_arr[$k++] = 'Driving';
            $existing2 = implode(',',$existing_arr);
            $verifications->existing = $existing2;
              return view('backend.verification.approve', compact('verifications','verification'));
          }else{
             return view('backend.verification.approve', compact('verification'));
          }
    }

    public function DisapproveVerification($data=false)
    {
         $verification = verification::where('nid_status',2)
         ->orWhere('passport_status',2)
         ->orWhere('driving_status',2)
         ->get();
        if($data){
            $verifications = verification::find($data);

            return view('backend.verification.disapprove',compact('verification','verifications'));
        }else{
            return view('backend.verification.disapprove',compact('verification'));
        }
      
    }
     public function allVerification($id=false)
    {
        $verification = verification::all();
        foreach ($verification as $key => $value) {
          $existing_arr = [];
          $k=0;
          if($value->nid_status==1) $existing_arr[$k++] ='NID';
          if($value->passport_status==1) $existing_arr[$k++] ='Passport';
          if($value->driving_status==1) $existing_arr[$k++] = 'Driving';
          $verification[$key]->existing_mess = implode(',',$existing_arr);
        }

          if($id){
            $verifications = verification::find($id);
              $existing_arr = [];
            $k=0;
            if($verifications->nid_status==1) $existing_arr[$k++] ='NID';
            if($verifications->passport_status==1) $existing_arr[$k++] ='Passport';
            if($verifications->driving_status==1) $existing_arr[$k++] = 'Driving';
            $existing2 = implode(',',$existing_arr);
            $verifications->existing = $existing2;
            return view('backend.verification.all',compact('verification','verifications'));
        }else{
            return view('backend.verification.all', compact('verification'));
        }
       // return view('backend.verification.all', compact('verification'));
    }
    public function editVerificationChange($id){
         //$productById= Product::where('id',$id)->first();
         $verification = verification::where('id',$id)->first();
        //dd($verification);
         return view('backend.verification.edit_verification', compact('verification'));
    

    }
     public function editVerificationPassport($id){
         //$productById= Product::where('id',$id)->first();
         $verification = verification::where('id',$id)->first();
        //dd($verification);
         return view('backend.verification.edit_verification_passport', compact('verification'));
    

    }
     public function editVerificationDriving($id){
         //$productById= Product::where('id',$id)->first();
         $verification = verification::where('id',$id)->first();
        //dd($verification);
         return view('backend.verification.edit_verification_driving', compact('verification'));
    

    }
    public function updateVerificationChange(Request $request){
        dd($request->all());
    }
      public function updateVerificationDriving(Request $request){
        dd($request->all());
    }
      public function updateVerificationPassport(Request $request){
        dd($request->all());
    }
     public function rejectReson(Request $request)
    { 
         $reject = new rejectReason;
         $reject->reject_message= $request->reject_message;

         $reject->save();
         return back();

    }
    public function profileManage($id=false){
         $users = user::orderBy('updated_at', 'desc')->get();
         $rejectphoto = rejectphoto::all();
        if($id){
            $verifications = user::find($id);
            $userinfo = verification::find($id);
             $existing_arr = [];
            $k=0;
            if($userinfo->nid_status==1) $existing_arr[$k++] ='NID';
            if($userinfo->passport_status==1) $existing_arr[$k++] ='Passport';
            if($userinfo->driving_status==1) $existing_arr[$k++] = 'Driving';
            $existing2 = implode(',',$existing_arr);
            $userinfo->existing = $existing2;
            return view('backend.verification.profile_manage',compact('users','verifications','userinfo','rejectphoto'));
        }else{
            return view('backend.verification.profile_manage',compact('users'));
        }
        //dd($users);
        //return view('backend.verification.profile_manage',compact('users'));
    }
     public function profileManagePhoto(Request $request){
      //dd($request->all());
      $users = user::find($request->id);
      $users->rejectphoto=$request->cbo_rej_mess;
      $users->photo_status=2;
      //dd($users);
      $users->update();
      return back();
    }
    public function profileManagePhotoApprove(Request $request){
      $users = user::find($request->id);
      //dd($users);
      $users->photo_status = 1;
      $users->update();
      return redirect('profile_manage');
    }
}

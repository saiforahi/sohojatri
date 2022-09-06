<?php

namespace App\Http\Controllers\frontend;

use App\Models\request_ride;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Session;

class RequestController extends Controller
{
    // api
    public function RequestPostAPI(Request $request){
        $request->validate([
            'start_lat' => 'required',
            'start_lng' => 'required',
            'end_lat' => 'required',
            'end_lng' => 'required',
            'start_location' => 'required',
            'end_location' => 'required',
            'journey_date' => 'required',
            //'before' => 'required',
            'seat' => 'required',
        ]);

        try{
            $insert = new request_ride;
            $insert->s_lat = $request->start_lat;
            $insert->s_lng = $request->start_lng;
            $insert->s_location = $request->start_location;
            $insert->e_lat = $request->end_lat;
            $insert->e_lng = $request->end_lng;
            $insert->e_location = $request->end_location;
            $insert->after = $request->journey_date;
            $insert->before = $request->before;
            $insert->seat = $request->seat;
            $insert->user_id = Auth::user()->id;
            $insert->save();
            return response()->json(['success'=>true,'message'=>'Ride request submitted','data'=>$insert],201);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage(),'data'=>[]],500);
        }

        
    }
    // web
    public function RequestPost(Request $request){
        $request->validate([
            'location' => 'required',
            'location2' => 'required',
            'after' => 'required',
            //'before' => 'required',
            'seat' => 'required',
        ]);

        if(Session::get('userId') == null && Session::get('phone') == null) {
            Session::flash('message', 'Submit this form Login first.');
            return view('frontend.request');
        }

        $insert = new request_ride;
        $insert->s_lat = $request->lat;
        $insert->s_lng = $request->lng;
        $insert->s_location = $request->location;
        $insert->e_lat = $request->lat2;
        $insert->e_lng = $request->lng2;
        $insert->e_location = $request->location2;
        $insert->after = $request->after;
        $insert->before = $request->before;
        $insert->seat = $request->seat;
        $insert->user_id = Session('userId');
        $insert->save();

        return view('frontend.request_congrates');
    }

    public function RequestNext(){
        $ride = request_ride::where('user_id',Session('userId'))->get();
        return view('frontend.request2',compact('ride'));
    }
}

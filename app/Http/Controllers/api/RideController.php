<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\post_ride;
use App\Models\post_ride_address;
use App\Models\stopover;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RideController extends Controller
{
    //

    public function post_ride(Request $request){
        try{
            $request->validate([
                'location' => 'required|string',
                'location2' => 'required',
                'departure' => 'required|date|after:today',
                'car' => 'required',
            ]);
            $serial = 1;
            $return = 0;
            $insert = new post_ride();
            $insert->s_lat = $request->lat;
            $insert->s_lng = $request->lng;
            $insert->s_location = $request->location;
            $insert->e_lat = $request->lat2;
            $insert->e_lng = $request->lng2;
            $insert->e_location = $request->location2;
            $insert->departure = $request->departure;
            $insert->d_time = $request->d_time;
            $insert->d_time2 = $request->d_time2;
            if ($request->return != null) {
                $insert->return = $request->return;
                $insert->r_time = $request->r_time;
                $insert->r_time2 = $request->r_time2;
                $return = 1;
            }
            $placeInfo = GetDrivingDistance($request->lat, $request->lng, $request->lat2, $request->lng2);
            $insert->distance = $placeInfo['distance'];
            $insert->duration = $placeInfo['time'];
            $insert->car_id = $request->car;
            $insert->driver = $request->driver;
            $insert->user_id = Session('userId');
            $insert->save();

            $this->RidePostAddress($request->lat, $request->lng, $request->location, $serial, $insert->id);
            $serial++;


            if ($request->alocation != null) {
                $this->RidePostAddress($request->alat, $request->alng, $request->alocation, $serial, $insert->id);
                $serial++;
            }

            if ($request->alocation1 != null) {
                $this->RidePostAddress($request->alat1, $request->alng1, $request->alocation1, $serial, $insert->id);
                $serial++;
            }

            if ($request->alocation2 != null) {
                $this->RidePostAddress($request->alat2, $request->alng2, $request->alocation2, $serial, $insert->id);
                $serial++;
            }

            if ($request->alocation3 != null) {
                $this->RidePostAddress($request->alat3, $request->alng3, $request->alocation3, $serial, $insert->id);
                $serial++;
            }

            if ($request->alocation4 != null) {
                $this->RidePostAddress($request->alat4, $request->alng4, $request->alocation4, $serial, $insert->id);
                $serial++;
            }

            if ($request->alocation5 != null) {
                $this->RidePostAddress($request->alat5, $request->alng5, $request->alocation5, $serial, $insert->id);
                $serial++;
            }

            if ($request->alocation6 != null) {
                $this->RidePostAddress($request->alat6, $request->alng6, $request->alocation6, $serial, $insert->id);
                $serial++;
            }

            if ($request->alocation7 != null) {
                $this->RidePostAddress($request->alat7, $request->alng7, $request->alocation7, $serial, $insert->id);
                $serial++;
            }

            if ($request->alocation8 != null) {
                $this->RidePostAddress($request->alat8, $request->alng8, $request->alocation8, $serial, $insert->id);
                $serial++;
            }

            if ($request->alocation9 != null) {
                $this->RidePostAddress($request->alat9, $request->alng9, $request->alocation9, $serial, $insert->id);
                $serial++;
            }

            $this->RidePostAddress($request->lat2, $request->lng2, $request->location2, $serial, $insert->id);

            $postCode = [];

            $ride = post_ride_address::where('post_id', $insert->id)->get();
            foreach ($ride as $rides) {
                array_push($postCode, $rides->serial);
            }


            $total = count($postCode);
            for ($i = 0; $i < $total; $i++) {
                if ($i == $total - 1) {
                    break;
                }
                for ($l = $i + 1; $l < $total; $l++) {

                    $insert1 = new stopover();
                    $insert1->going = $postCode[$i];
                    $insert1->target = $postCode[$l];
                    $insert1->post_id = $insert->id;
                    $insert1->date = $request->departure;
                    $insert1->time = $request->d_time;
                    $insert1->time2 = $request->d_time2;
                    $ride_id = post_ride::all()->count();
                    $ride_id = "R" . rand(100, 999) . str_pad($ride_id, 3, "0", STR_PAD_LEFT);
                    $insert1->tracking = $ride_id;
                    $placeInfo = $this->GetPlaceDisTime($postCode[$i], $postCode[$l], $insert->id);
                    $insert1->distance = $placeInfo['distance'];
                    $insert1->duration = $placeInfo['time'];
                    $input = $request->departure . ' ' . $request->d_time . ' ' . $request->d_time2;
                    $date = Carbon::createFromFormat('m/d/Y h A', $input, 'Asia/Dhaka');
                    date_add($date, date_interval_create_from_date_string($placeInfo['time']));
                    $insert1->edate = date_format($date, 'm/d/Y');
                    $insert1->etime = date_format($date, 'h');
                    $insert1->etime2 = date_format($date, 'A');
                    $insert1->save();


                }
            }

            if ($return == 1) {
                for ($i = $total - 1; $i >= 1; $i--) {
                    for ($l = $i - 1; $l >= 0; $l--) {
                        $insert1 = new stopover;
                        $insert1->going = $postCode[$i];
                        $insert1->target = $postCode[$l];
                        $insert1->post_id = $insert->id;
                        $insert1->date = $request->return;
                        $insert1->time = $request->r_time;
                        $insert1->time2 = $request->r_time2;
                        $ride_id = post_ride::all()->count();
                        $ride_id = "R" . rand(100, 999) . str_pad($ride_id, 3, "0", STR_PAD_LEFT);
                        $insert1->tracking = $ride_id;
                        $insert1->save();
                    }
                }

            }
            return response()->json(['success'=>true,'message'=>'Ride posted'],200);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'errors'=>$e->getMessage()], 404);
        }
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use App\Models\post_ride;
use App\Models\post_ride_address;
use App\Models\ride_setting;
use App\Models\stopover;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RideController extends Controller
{
    //
    public function RidePostAddress($lat, $lng, $location, $serial, $post)
    {
        $insert = new post_ride_address;
        $insert->lat = $lat;
        $insert->lng = $lng;
        $insert->location = $location;
        $insert->serial = $serial;
        $insert->post_id = $post;
        $insert->save();
    }
    public function GetPlaceDisTime($going, $target, $id)
    {
        $s_lat = PostRideAddress($id, $going, 'lat');
        $s_lng = PostRideAddress($id, $going, 'lng');
        $e_lat = PostRideAddress($id, $target, 'lat');
        $e_lng = PostRideAddress($id, $target, 'lng');

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=" . $s_lat . "," . $s_lng . "&destinations=" . $e_lat . "," . $e_lng . "&key=" . env('MAP_KEY');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        if (isset($response_a['rows'][0]['elements'][0]['distance'])) {
            $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
            $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
        } else {
            $dist = 0;
            $time = 0;
        }

        return array('distance' => $dist, 'time' => $time);
    }

    public function post_ride_step1(Request $request)
    {
        try {
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
            $insert->user_id = Auth::user()->id;
            $insert->save();
            $posted_ride = $insert;

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
                    $date = Carbon::createFromFormat('Y-m-d h A', $input, 'Asia/Dhaka')->addDays($placeInfo['time']);
                    // date_add($date, date_interval_create_from_date_string($placeInfo['time']));
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
            $ride = $posted_ride;
            $stopovers = stopover::where('post_id', $posted_ride->id)->get();
            foreach ($stopovers as $stopover) {
                $stopover['start'] = PostRideAddress($stopover->post_id, $stopover->going, 'location');
                $stopover['end'] = PostRideAddress($stopover->post_id, $stopover->target, 'location');
            }
            $ride_settings = ride_setting::first();
            $data = array('ride' => $posted_ride, 'stopovers' => $stopovers, 'ride_settings' => $ride_settings);
            return response()->json(['success' => true, 'message' => 'Ride posted', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => 'at line ' . $e->getLine() . ' ' . $e->getMessage(), 'data' => $e->getTrace()], 404);
        }
    }

    // step 2

    public function post_ride_step2(Request $request)
    {
        try {
            // dd($request->all());
            $stopover = stopover::where('post_id', $request->id)->get();
            $post = post_ride::find($request->id);
            $post->seat = $request->seat;
            $post->save();

            $chks = (array)$request->price;
            $list = 0;
            foreach ($stopover as $stopovers) {
                $insert = stopover::find($stopovers->id);
                $insert->price = $chks[$list];
                $insert->save();
                $list++;
            }
            $conditions = Condition::all();
            $data = array('conditions' => $conditions, 'ride' => $post, 'stopovers' => stopover::where('post_id', $request->id)->get());
            return response()->json(['success' => true, 'message' => 'Ride fares posted', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => 'at line ' . $e->getLine() . ' ' . $e->getMessage(), 'data' => $e->getTrace()], 404);
        }
    }

    // step 3

    public function post_ride_step3(Request $request)
    {
        try {
            $request->merge([
                'condition' => implode(',', (array)$request->get('condition'))
            ]);
            $post = post_ride::find($request->id);
            $post->condition = $request->condition;
            $post->save();
            return response()->json(['success' => true, 'message' => 'Ride conditions posted', 'data' => $post], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => 'at line ' . $e->getLine() . ' ' . $e->getMessage(), 'data' => $e->getTrace()], 404);
        }
    }

    public function find_ride(Request $req)
    {
        try {
            $rules = [
                'lat' => 'required',
                'lng' => 'required',
                'location' => 'required',
                'lat2' => 'required',
                'lng2' => 'required',
                'location2' => 'required',
                'date' => 'required|date|after_or_equal:today',
                'seat'=> 'required|numeric'
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            $userLat = $req->lat;
            $userLng = $req->lng;
            $userLoca = $req->location;
            $userLat2 = $req->lat2;
            $userLng2 = $req->lng2;
            $userLoca2 = $req->location2;
            $filter = true;
            $stopovers = stopover::where('stopovers.date','>=',date('m/d/Y',strtotime($req->date)))->join('post_rides','post_rides.id','=','stopovers.post_id')->where('post_rides.e_lat',$req->lat2)->get();
            // dd($stopover);
            $setting = ride_setting::first();
            $rides=[];
            foreach ($stopovers as $stopover) {
                $s_location = PostRideAddress($stopover->post_id, $stopover->going, 'location');
                $e_location = PostRideAddress($stopover->post_id, $stopover->target, 'location');
                $s_lat = PostRideAddress($stopover->post_id, $stopover->going, 'lat');
                $s_lng = PostRideAddress($stopover->post_id, $stopover->going, 'lng');
                $e_lat = PostRideAddress($stopover->post_id, $stopover->target, 'lat');
                $e_lng = PostRideAddress($stopover->post_id, $stopover->target, 'lng');
                //dd(date('Y-m-d',strtotime($stopovers->date)),date('Y-m-d',strtotime($after)));die();
                if (distance($s_lat, $s_lng, $userLat, $userLng, "K") < $setting->search && distance($e_lat, $e_lng, $userLat2, $userLng2, "K") < $setting->search && seat($stopover->going,$stopover->target,$stopover->post_id,$stopover->date) <= $req->seat) {
                    $time = $stopover->time.':00 '.$stopover->time2;
                    $ride = array('departure'=>$s_location,'destination'=>$e_location);
                    $driver=array('image'=>userInformation(getRide($stopover->post_id)->user_id,'image'),'name'=>userInformation(getRide($stopover->post_id)->user_id,'name'));
                    $price_seat = array('price'=>$stopover->price,'seats'=>seat($stopover->going,$stopover->target,$stopover->post_id,$stopover->date));
                    $conditions=Condition::whereIn('id',explode(",", getRide($stopover->post_id)->condition))->get();
                    $rating=3;
                    array_push($rides,array('time'=>$time,'ride'=>$ride,'driver'=>$driver,'price_seat'=>$price_seat,'conditions'=>$conditions,'rating'=>$rating));
                }
            }
            return response()->json(['success' => true, 'message' => 'Ride conditions posted', "data" => array('rides' => $rides)], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => 'at line ' . $e->getLine() . ' ' . $e->getMessage(), 'data' => $e->getTrace()], 404);
        }
    }
}

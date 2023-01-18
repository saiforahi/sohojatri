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
use DB;
use App\Models\User;
use App\Models\resource;
use App\Models\booking;
use App\Models\car;
use Session;

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
    
    public function post_ride(Request $request){
        
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
            $posted_ride = $insert->id;

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

            $ride = post_ride_address::where('post_id', $posted_ride)->get();
        
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
            
            $stopovers = stopover::where('post_id', $posted_ride)->get();
            
            foreach ($stopovers as $stopover) {
                $stopover['start'] = PostRideAddress($stopover->post_id, $stopover->going, 'location');
                $stopover['end'] = PostRideAddress($stopover->post_id, $stopover->target, 'location');
            }
            $ride_settings = ride_setting::first();
            $data = array('ride' => $posted_ride, 'stopovers' => $stopovers, 'ride_settings' => $ride_settings);
            
            
            /* 2nd part */
            
            
            $stopover = stopover::where('post_id', $posted_ride)->get();
        
            $post = post_ride::find($posted_ride);
            $post->seat = $request->seat;
            $post->save();
            
            $chks = (array)$request->price;
            $list = 0;
            foreach ($stopover as $stopovers) {
                $stopover = stopover::find($stopovers->id);
                $stopover->price = $chks[$list];
                $stopover->save();
                $list++;
            }
            $conditions = Condition::all();
            $data = array('ride' => $post, 'stopovers' => stopover::where('post_id',$posted_ride)->get());
            
            
            /* 3rd part */
            
            
            $request->merge([
                'condition' => implode(',', (array)$request->get('condition'))
            ]);
            $post = post_ride::find($posted_ride);
            $post->condition = $request->condition;
            $post->save();
            //dd($request->get('delete_id'));
            if($request->get('delete_id') != null && count($request->get('delete_id')) != 0){
                $stopovers_del = stopover::where('post_id', $posted_ride)->get();
                
                foreach($stopovers_del as $key=>$stopover_del){
                    if(in_array($key,$request->get('delete_id'))){
                        stopover::where('id',$stopover_del->id)->delete();
                    }
                }
            }
            
            
            
            return response()->json(['success' => true, 'message' => 'Ride posted', 'data' => $data], 200);
            
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => 'at line ' . $e->getLine() . ' ' . $e->getMessage(), 'data' => $e->getTrace()], 404);
        }
    }
    
    
    
    public function all_ride()
    {
        $ride = stopover::where('date', '>=', date("m/d/Y"))->where('status', 0)->get();
        
        foreach ($ride as $item) {
            $item["time"] =  $item->date. $item->time. $item->time2;
            $item['rider'] = getRide($item->post_id)->driver;
            $item['condition'] = getRide($item->post_id)->condition;
            $item['rider_img'] = count(resource_name(getRide($item->post_id)->driver)) != 0? resource_name(getRide($item->post_id)->driver)[0]->image:NULL;
            $item['user_id'] = count(resource_name(getRide($item->post_id)->driver)) != 0? resource_name(getRide($item->post_id)->driver)[0]->user_id:NULL;
            $item['distance'] = $item->distance;
            $item['duration'] = $item->duration;
            $item['fare'] = $item->price;
            $item['e_date_time'] = (int)$item->etime." ".$item->etime2;
            

            $s_location = explode(",", PostRideAddress($item->post_id, $item->going, 'location'));
            $e_location = explode(",", PostRideAddress($item->post_id, $item->target, 'location'));
            
            for($x = count($s_location)-2; $x < count($s_location); $x++){
               $start_location[] = $s_location[$x].',';
            }
            
            $item['start_location'] = implode(" ",array_slice($start_location, -2, 2, true));
            
            for($x = count($e_location)-2; $x < count($e_location); $x++){
               $end_location[] = $e_location[$x].',';
            }
            
            $item['end_location'] = implode(" ",array_slice($end_location, -2, 2, true));
            
            
        }
        
        return response()->json(['success' => true, 'message' => 'All Ride List', 'data' => $ride], 200);
        
    }
    
    
    
    public function booking_details($data, $data2 = false)
    {
        $singleStopovers = stopover::where('tracking', $data)->first();
        $booking = booking::where('tracking', $singleStopovers->tracking)->where('status', 1)->get();
        $post = post_ride::where('id', $singleStopovers->post_id)->first();
        $all_post = post_ride::where('user_id', $post->user_id)->get();
        $car = car::where('user_id', $post->user_id)->where('id', $post->car_id)->first();
       
        return response()->json(['success' => true, 'message' => 'Booking Details List', 'singleStopovers' => $singleStopovers,'all_post' => $all_post,'post' => $post,'car'=> $car,'booking' => $booking], 200);
        
    }
    
    
    public function rider_details($id)
    {
        $user = user::where('user_id', $id)->first();
        $all_post = post_ride::where('user_id', $id)->where('status', 1)->get();
        $resource = Resource::where('user_id', $id)->get()->count();
        
        
        return response()->json(['success' => true, 'message' => 'Rider details', 'user' => $user,'all_post' => $all_post,'resource' => $resource ], 200);
        
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
            
            $stopover_all = stopover::where('post_id', $request->id)->get();
            
            foreach ($stopover_all as $stopover_alls) {
                $stopover_alls['start'] = PostRideAddress($stopover_alls->post_id, $stopover_alls->going, 'location');
                $stopover_alls['end'] = PostRideAddress($stopover_alls->post_id, $stopover_alls->target, 'location');
            }
            
            $data = array('conditions' => $conditions, 'ride' => $post, 'stopovers' => $stopover_all);
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


    public function stopoverDelete($id){
        
        $stopovers_single = DB::table('stopovers')->where('id', $id)->first();
        
        if($stopovers_single != null){
            DB::table('stopovers')->where('id', $id)->delete();
            $posted_ride = post_ride::where('id',$stopovers_single->post_id)->get();
            
            $stopovers = stopover::where('post_id', $stopovers_single->post_id)->get();
            
            foreach ($stopovers as $stopover) {
                $stopover['start'] = PostRideAddress($stopover->post_id, $stopover->going, 'location');
                $stopover['end'] = PostRideAddress($stopover->post_id, $stopover->target, 'location');
            }
            
            $ride_settings = ride_setting::first();
            
            $data = array('ride' => $posted_ride, 'stopovers' => $stopovers, 'ride_settings' => $ride_settings);
            return response()->json(['success' => true, 'message' => 'stopover deleted successfully', 'data' => $data], 200);
            
        }else{
            return response()->json(['success' => true, 'message' => 'stopover not found'], 200);
        }
        
    }
    
    public function find_ride(Request $request)
    {
        
        $request->validate([
            'location' => 'required',
            'location2' => 'required'
        ]);


        $userLat = $request->lat;
        $userLng = $request->lng;
        $userLoca = $request->location;
        $userLat2 = $request->lat2;
        $userLng2 = $request->lng2;

        $userLoca2 = $request->location2;

        $after = $request->after;
        $before = $request->before;
        $seat = $request->seat;
        $count = 1;
        
        $stopover = stopover::where('stopovers.date','>=',date('m/d/Y',strtotime($after)))->join('post_rides','post_rides.id','=','stopovers.post_id')->where('post_rides.e_lat',$request->lat2)->get();
        $setting = ride_setting::first();
        
        foreach ($stopover as $stopovers) {
            $s_location = PostRideAddress($stopovers->post_id, $stopovers->going, 'location');
            $e_location = PostRideAddress($stopovers->post_id, $stopovers->target, 'location');
            $s_lat = PostRideAddress($stopovers->post_id, $stopovers->going, 'lat');
            $s_lng = PostRideAddress($stopovers->post_id, $stopovers->going, 'lng');
            $e_lat = PostRideAddress($stopovers->post_id, $stopovers->target, 'lat');
            $e_lng = PostRideAddress($stopovers->post_id, $stopovers->target, 'lng');
            if (strtotime($stopovers->date) >= strtotime($after) && strtotime($stopovers->date) <= strtotime($after)) {
                if (distance($s_lat, $s_lng, $userLat, $userLng, "K") < $satting->search && distance($e_lat, $e_lng, $userLat2, $userLng2, "K") < $satting->search) {
                    $count++;
                }
            }
        }
        if ($count > 1) {
            $show = 1;
        } else {
            $show = 2;
        }

    
        return response()->json(['success' => true, 'message' => 'Ride list', 'stopover' => $stopover,'setting'=>$setting,'userLat'=>$userLat,'userLng'=>$userLng,'seat'=>$seat,'userLat2'=>$userLat2,
        'userLng2'=>$userLng2,'userLoca'=>$userLoca,'after'=>$after,'before'=>$before,'show'=>$show], 200);
        
    }
}

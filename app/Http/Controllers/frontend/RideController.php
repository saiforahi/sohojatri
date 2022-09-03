<?php

namespace App\Http\Controllers\frontend;

use App\Models\popular_ride;
use App\Models\post_ride;
use App\Models\resource;
use App\Models\ride_setting;
use App\Models\stopover;
use App\Models\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RideController extends Controller
{

    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }


    public function Ride()
    {

        $ride = stopover::where('date', '>=', date("m/d/Y"))->where('status', 0)->get();
        $rideDate = "";

        $tracking = [];
        $group = [];
        foreach ($ride as $item) {
            if (getRide($item->post_id)->status == 1) {
                if (!in_array($item->date, $group)) {
                    array_push($group, $item->date);
                }
            }
        }
        $date_sort = function ($a, $b) {
            return strtotime($a) - strtotime($b);
        };
        usort($group, $date_sort);
        $filter = true;
        return view('frontend.all_ride', compact('ride', 'group', 'rideDate', 'tracking', 'filter'));
    }

    public function Rider($id)
    {
        $user = user::where('user_id', $id)->first();
        $all_post = post_ride::where('user_id', $id)->where('status', 1)->get();
        $resource = Resource::where('user_id', $id)->get()->count();
        return view('frontend.rider', compact('user', 'all_post', 'resource'));
    }

    public function RideSearch(Request $request, $id = null)
    {
        $filter = true;
        if ($id) {
            $popular = popular_ride::findOrFail($id);
            $userLat = $popular->s_lat;
            $userLng = $popular->s_lng;
            $userLoca = $popular->s_location;
            $userLat2 = $popular->e_lat;
            $userLng2 = $popular->e_lng;
            $userLoca2 = $popular->e_location;
            $filter = false;
        } else {
            $userLat = $request->lat;
            $userLng = $request->lng;
            $userLoca = $request->location;
            $userLat2 = $request->lat2;
            $userLng2 = $request->lng2;
            $userLoca2 = $request->location2;
            $filter = false;
        }

        $rideDate = $request->date;


        $ride = stopover::where('date', '>=', date("m/d/Y",strtotime($rideDate)))->where('status', 0)->get();
        //$ride = stopover::where('status', 0)->get();
        $satting = ride_setting::first();

        $tracking = [];
        $group = [];
        foreach ($ride as $item) {
            if (getRide($item->post_id)->status == 1) {
                if (!in_array($item->date, $group)) {
                    array_push($group, $item->date);
                }
            }
        }
        $date_sort = function ($a, $b) {
            return strtotime($a) - strtotime($b);
        };
        usort($group, $date_sort);
        if ($userLoca != "") {
            foreach ($ride as $item) {
                $s_lat = PostRideAddress($item->post_id, $item->going, 'lat');
                $s_lng = PostRideAddress($item->post_id, $item->going, 'lng');
                $e_lat = PostRideAddress($item->post_id, $item->target, 'lat');
                $e_lng = PostRideAddress($item->post_id, $item->target, 'lng');
                if (distance($s_lat, $s_lng, $userLat, $userLng, "K") < $satting->search) {
                    if ($userLoca2 != "") {
                        if (distance($e_lat, $e_lng, $userLat2, $userLng2, "K") < $satting->search) {
                            array_push($tracking, $item->tracking);
                        }
                    } else {
                        array_push($tracking, $item->tracking);
                    }
                }
            }
        }

        if ($userLoca2 != "") {
            foreach ($ride as $item) {

                $e_lat = PostRideAddress($item->post_id, $item->target, 'lat');
                $e_lng = PostRideAddress($item->post_id, $item->target, 'lng');
                if (distance($e_lat, $e_lng, $userLat2, $userLng2, "K") < $satting->search) {
                    if ($userLoca == "") {
                        if (!in_array($item->tracking, $tracking)) {
                            array_push($tracking, $item->tracking);
                        }
                    }
                }
            }
        }

        return view('frontend.all_ride', compact('ride', 'group', 'rideDate', 'tracking', 'userLat', 'userLng', 'userLat2', 'userLng2'
            , 'userLoca', 'userLoca2', 'filter'));
    }


    public function FindRide()
    {
        $show = 3;
        return view('frontend.find_ride', compact('show'));
    }

    public function FindRideSearch(Request $request)
    {
        $request->validate([
            'location' => 'required',
            'location2' => 'required',
            //'after' => 'required',
            //'before' => 'required',
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

        //$stopover = stopover::all();
        $stopover = stopover::where('date','>=',date('m/d/Y',strtotime($after)))->get();

        $satting = ride_setting::first();
        //dd($stopover,$satting);die();
        foreach ($stopover as $stopovers) {
            $s_location = PostRideAddress($stopovers->post_id, $stopovers->going, 'location');
            $e_location = PostRideAddress($stopovers->post_id, $stopovers->target, 'location');
            $s_lat = PostRideAddress($stopovers->post_id, $stopovers->going, 'lat');
            $s_lng = PostRideAddress($stopovers->post_id, $stopovers->going, 'lng');
            $e_lat = PostRideAddress($stopovers->post_id, $stopovers->target, 'lat');
            $e_lng = PostRideAddress($stopovers->post_id, $stopovers->target, 'lng');
            //dd(date('Y-m-d',strtotime($stopovers->date)),date('Y-m-d',strtotime($after)));die();
            if (strtotime($stopovers->date) >= strtotime($after) && strtotime($stopovers->date) <= strtotime($after)) {
            //if (strtotime($stopovers->date) >= strtotime($after) && strtotime($stopovers->date) <= strtotime($after)) {
            //if (date('Y-m-d',strtotime($stopovers->date)) == date('Y-m-d',strtotime($after))) {
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


        return view('frontend.find_ride', compact('stopover', 'satting', 'userLat', 'userLng', 'seat', 'userLat2', 'userLng2'
            , 'userLoca', 'userLoca2', 'after', 'before', 'show'));
    }

    public function PopularRide()
    {
        $popular = popular_ride::all();
        return view('frontend.popular_ride', compact('popular'));
    }

    public function PopularRideShow($data)
    {

        $stopover = stopover::where('tracking', $data)->first();

        $rideDate = $stopover->date;
        $userLat = PostRideAddress($stopover->post_id, $stopover->going, 'lat');
        $userLng = PostRideAddress($stopover->post_id, $stopover->going, 'lng');
        $userLat2 = PostRideAddress($stopover->post_id, $stopover->target, 'lat');
        $userLng2 = PostRideAddress($stopover->post_id, $stopover->target, 'lng');

        $userLoca = PostRideAddress($stopover->post_id, $stopover->going, 'location');
        $userLoca2 = PostRideAddress($stopover->post_id, $stopover->target, 'location');

        $ride = stopover::all();
        $satting = ride_setting::first();

        $tracking = [];
        $group = [];
        foreach ($ride as $item) {
            if (getRide($item->post_id)->status == 1) {
                if (!in_array($item->date, $group)) {
                    array_push($group, $item->date);
                }
            }
        }
        $date_sort = function ($a, $b) {
            return strtotime($a) - strtotime($b);
        };
        usort($group, $date_sort);


        foreach ($ride as $item) {
            $s_lat = PostRideAddress($item->post_id, $item->going, 'lat');
            $s_lng = PostRideAddress($item->post_id, $item->going, 'lng');
            $e_lat = PostRideAddress($item->post_id, $item->target, 'lat');
            $e_lng = PostRideAddress($item->post_id, $item->target, 'lng');
            if (distance($s_lat, $s_lng, $userLat, $userLng, "K") < $satting->search) {
                if (distance($e_lat, $e_lng, $userLat2, $userLng2, "K") < $satting->search) {
                    array_push($tracking, $item->tracking);
                }
            }
        }


        foreach ($ride as $item) {

            $e_lat = PostRideAddress($item->post_id, $item->target, 'lat');
            $e_lng = PostRideAddress($item->post_id, $item->target, 'lng');
            if (distance($e_lat, $e_lng, $userLat2, $userLng2, "K") < $satting->search) {
                if (!in_array($item->tracking, $tracking)) {
                    array_push($tracking, $item->tracking);
                }
            }
        }


        return view('frontend.all_ride', compact('ride', 'group', 'rideDate', 'tracking', 'userLat', 'userLng', 'userLat2', 'userLng2'
            , 'userLoca', 'userLoca2'));
    }

}

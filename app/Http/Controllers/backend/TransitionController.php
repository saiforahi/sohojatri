<?php

namespace App\Http\Controllers\backend;

use App\faulty_trip;
use App\popular_ride;
use App\post_ride;
use App\post_time_update;
use App\ride_setting;
use App\stopover;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class TransitionController extends Controller
{
    public function Transition(Request $request)
    {

        if ($request->userId && $request->userId != "") {
            $userId = $request->userId;
        } else {
            $userId = "";
        }

        if ($request->tracking && $request->tracking != "") {
            $tracking = $request->tracking;
        } else {
            $tracking = "";
        }

        if ($request->filter && $request->filter == 4) {
            $filter = 4;
        } elseif ($request->filter && $request->filter != "") {
            $filter = $request->filter;
        } else {
            $filter = "";
        }

        $postId = [];
        if ($userId != "") {
            $post = post_ride::where('status', 1)->where('user_id', $userId)->get();
        } else {
            $post = post_ride::where('status', 1)->get();
        }

        foreach ($post as $posts) {
            array_push($postId, $posts->id);
        }
        $stopover = stopover::whereIn('post_id', $postId)->whereNotIn('status', [2, 3, 4])->get();

        foreach ($stopover as $stopovers) {
            $timezone = 'Asia/Dhaka';
            $input = $stopovers->date . ' ' . $stopovers->time . ' ' . $stopovers->time2;
            $date = Carbon::createFromFormat('m/d/Y h A', $input, 'Asia/Dhaka');
            $today = Carbon::parse($date, $timezone);
            $input = $stopovers->edate . ' ' . $stopovers->etime . ' ' . $stopovers->etime2;
            $date = Carbon::createFromFormat('m/d/Y h A', $input, 'Asia/Dhaka');
            $tomorrow = Carbon::parse($date, $timezone);
            $now = Carbon::now($timezone);
            if ($now->gte($today) && $now->lte($tomorrow)) {
                $update = stopover::find($stopovers->id);
                $update->status = 1;
                $update->save();

            } else if ($now->gte($tomorrow) && $now->gte($tomorrow)) {
                $update = stopover::find($stopovers->id);
                $update->status = 2;
                $update->save();
            }

        }


        if ($tracking != "" && $filter != "") {
            $stopover = stopover::whereIn('post_id', $postId)->where('tracking', $tracking)->where('status', $filter)->get();
        } elseif ($tracking != "") {
            $stopover = stopover::whereIn('post_id', $postId)->where('tracking', $tracking)->get();
        } elseif ($filter == 4) {
            $stopover = stopover::whereIn('post_id', $postId)->where('status', 0)->get();
        } elseif ($filter != "") {
            $stopover = stopover::whereIn('post_id', $postId)->where('status', $filter)->get();
        } else {
            $stopover = stopover::whereIn('post_id', $postId)->orderBy('date', 'desc')->get();
        }

        $setting = ride_setting::all()->pluck('commission')->first();
        return view('backend.transition', compact('stopover', 'userId', 'tracking', 'filter', 'setting'));
    }

    public function TransitionUpdate(Request $request)
    {
        $stopover = stopover::find($request->id);
        $stopover->status = 3;
        $stopover->save();

        return redirect('admin-transition');
    }

    public function PopularRide(Request $request)
    {
        $ride = popular_ride::all();
        return view('backend.popular_ride', compact('ride'));
    }

    public function PopularRideStore(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'lat' => 'required',
            'lng' => 'required',
            'location' => 'required',
            'lat2' => 'required',
            'lng2' => 'required',
            'location2' => 'required',
            'payment' => 'required',
        ]);

        $insert = new popular_ride();
        $insert->s_lat = $request->lat;
        $insert->s_lng = $request->lng;
        $insert->s_location = $request->location;
        $insert->e_lat = $request->lat2;
        $insert->e_lng = $request->lng2;
        $insert->e_location = $request->location2;
        $insert->payment = $request->payment;
        $insert->save();

        Session::flash('message', 'Popular ride post successfully');
        return redirect('admin-popular-ride');
    }

    public function PopularRideDelete($id)
    {
        popular_ride::find($id)->delete();
        Session::flash('message', 'Popular ride Delete Successfully');
        return redirect('admin-popular-ride');
    }

    public function PendingPostProfile($data)
    {

        $post = post_ride::find($data);
        $stopover = stopover::where('post_id', $data)->get();
        return view('backend.popular_ride2', compact('stopover', 'post'));

    }

    public function PendingPostUpdate(Request $request)
    {
        if ($request->add) {
            $insert = new popular_ride;
            $insert->tracking = base64_decode($request->add);
            $insert->save();
            return redirect()->back();
        } else if ($request->remove) {
            popular_ride::where('tracking', base64_decode($request->remove))->delete();
            return redirect()->back();
        }

    }

    public function faultyTrip(Request $request)
    {
        $ride = stopover::where('tracking', $request->tracking)->first();
        $ride->status = 4;
        $ride->save();

        $insert = new faulty_trip();
        $insert->tracking = $request->tracking;
        $insert->reason = $request->reason;
        $insert->save();

        return redirect('admin-transition');
    }

    public function faultyTripShow()
    {
        $trip = faulty_trip::all();
        return view('backend.faulty_trip', compact('trip'));
    }

    public function timeUpdate()
    {
        $trip = post_time_update::all();
        return view('backend.time_update', compact('trip'));
    }

    public function timeUpdateDone($data)
    {
        $post = post_time_update::find($data);
        $insert = post_ride::find($post->post_id);
        $insert->departure = $post->departure;
        $insert->d_time = $post->d_time;
        $insert->d_time2 = $post->d_time2;
        $insert->save();

        $stopover = stopover::where('post_id', $insert->id)->get();
        foreach ($stopover as $stopovers) {
            $insert1 = stopover::find($stopovers->id);
            $insert1->date = $post->departure;
            $insert1->time = $post->d_time;
            $insert1->time2 = $post->d_time2;
            $input = $post->departure . ' ' . $post->d_time . ' ' . $post->d_time2;
            $date = Carbon::createFromFormat('m/d/Y h A', $input, 'Asia/Dhaka');
            date_add($date, date_interval_create_from_date_string($insert1->duration));
            $insert1->edate = date_format($date, 'm/d/Y');
            $insert1->etime = date_format($date, 'h');
            $insert1->etime2 = date_format($date, 'A');
            $insert1->save();
        }

        $post->status = 1;
        $post->save();

        return redirect()->back();

    }

}

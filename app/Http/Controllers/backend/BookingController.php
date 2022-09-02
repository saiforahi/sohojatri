<?php

namespace App\Http\Controllers\backend;

use App\stopover;
use App\post_ride;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{

    public function CompleteBook($id = false)
    {
        if ($id == "time") {
            $stopover = stopover::whereIn('status', [0, 1])->orderBy('date', 'desc')->get();
            return view('backend.booking.complete_book', compact('stopover', 'id'));
        } else {
            $stopover = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->where('stopovers.status', 1)->orderBy('stopovers.date', 'desc')->get();
            return view('backend.booking.complete_book', compact('stopover'));
        }

    }

    public function PartialBook($id = false)
    {
        if ($id == "time") {
            $stopover = stopover::whereIn('status', [0, 1])->orderBy('date', 'desc')->get();
            return view('backend.booking.partial_book', compact('stopover', 'id'));
        } else {
            $stopover = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->where('stopovers.status', 1)->orderBy('stopovers.date', 'desc')->get();
            return view('backend.booking.partial_book', compact('stopover'));
        }

    }

    public function NotBook($id = false)
    {
        if ($id == "time") {
            $stopover = stopover::whereIn('status', [0, 1])->orderBy('date', 'desc')->get();
            return view('backend.booking.not_book', compact('stopover', 'id'));
        } else {
            $stopover = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->whereIn('stopovers.status', [0, 1])->orderBy('stopovers.date', 'desc')->get();
            return view('backend.booking.not_book', compact('stopover'));
        }
    }


    public function OngoingBook()
    {
        $stopover = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->where('stopovers.date', '>=', date("m/d/Y"))->orderBy('stopovers.date', 'desc')->get();
        return view('backend.booking.ongoing_book', compact('stopover'));
    }


    public function CompleteRide()
    {
        $stopover = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->where('stopovers.date', '<', date("m/d/Y"))->whereNotIn('stopovers.status', [0, 1])->orderBy('stopovers.date', 'desc')->get();
        return view('backend.booking.complete_ride', compact('stopover'));
    }

    public function BookingList()
    {
        $stopover = stopover::join('post_rides', 'stopovers.post_id', '=', 'post_rides.id')->select('stopovers.*')->where('post_rides.status', 1)->orderBy('stopovers.date', 'desc')->get();
        return view('backend.booking.booking_list', compact('stopover'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

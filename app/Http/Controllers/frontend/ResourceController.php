<?php

namespace App\Http\Controllers\frontend;

use App\resource;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{

    public function Index()
    {
        $resource = resource::where('user_id',Session('userId'))->where('status','!=',3)->get();
        return view('frontend.sp_panel.resource.resource',compact('resource'));
    }

    public function ResourceRemove()
    {
        $resource = resource::where('user_id',Session('userId'))->where('status','=',3)->get();
        return view('frontend.sp_panel.resource.restore_resource',compact('resource'));
    }


    public function Store(Request $request)
    {
        $request->validate([
            'phone' => 'required|max:15|unique:resources',
            'name' => 'required|max:35',
            'national_id' => 'required|max:50|unique:resources',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'nid_image1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'nid_image2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000'
        ]);

        $insert = new resource;
        $insert->name = $request->name;
        $insert->phone = $request->phone;
        $insert->national_id = $request->national_id;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileStore3 = rand(10, 100) . time() . "." . $extension;
            $request->file('image')->storeAs('public/resource', $fileStore3);
            $insert->image = $fileStore3;
        }

        if ($request->hasFile('nid_image1')) {
            $extension = $request->file('nid_image1')->getClientOriginalExtension();
            $fileStore3 = rand(10, 100) . time() . "." . $extension;
            $request->file('nid_image1')->storeAs('public/resource', $fileStore3);
            $insert->nid_image1 = $fileStore3;
        }

        if ($request->hasFile('nid_image2')) {
            $extension = $request->file('nid_image2')->getClientOriginalExtension();
            $fileStore3 = rand(10, 100) . time() . "." . $extension;
            $request->file('nid_image2')->storeAs('public/resource', $fileStore3);
            $insert->nid_image2 = $fileStore3;
        }
        $insert->resource_id = time();
        $insert->user_id = Session('userId');
        $insert->save();

        Session::flash('message', 'Resource Add Successfully');
        return redirect('resource');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Delete($id)
    {
        $delete = resource::find($id);
        $delete->status = 3;
        $delete->save();

        Session::flash('message', 'Resource Delete Successfully');
        return redirect('resource');
    }

    public function RestoreRestore($id)
    {
        $delete = resource::find($id);
        $delete->status = 0;
        $delete->save();

        Session::flash('message', 'Resource Restore Successfully');
        return redirect('resource');
    }
}

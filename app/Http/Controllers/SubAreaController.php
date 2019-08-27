<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SubArea;
use App\Area;
use App\User;

class SubAreaController extends Controller
{

    //authenticated users can access these methods only
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subareas = SubArea::all();
        return view('pages.subArea.index',compact('subareas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::all();
        return view('pages.subArea.create',compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $messages = array(
            'subArea_name.required' => 'Sub Area Name is Required.',
            'area_id.required' => 'Area Name is Required.',
        );
        $this->validate($request, array(
            'area_id' => 'required',
            'subArea_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $subarea = new SubArea;

        $subarea->subArea_name = $request->subArea_name;
        $subarea->area_id = $request->area_id;
        $subarea->added_by = Auth::user()->id;
        $subarea->subArea_details = $request->subArea_details;

        $subarea->save();

        return redirect('/subarea')->with('status', 'New Sub Area Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subarea = SubArea::find($id);
        $added_by = User::withTrashed()->find($subarea->added_by);
        $edited_by = User::withTrashed()->find($subarea->edited_by);
        $salesmen = User::where([
                        ['subArea_id','=', $id]
                    ])->get();
        return view('pages.subArea.show',compact('subarea','added_by','edited_by','salesmen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $areas = Area::all();
        $subarea = SubArea::find($id);
        return view('pages.subArea.edit',compact('subarea','areas'));
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
        //validation
        $messages = array(
            'subArea_name.required' => 'Sub Area Name is Required.',
            'area_id.required' => 'Area Name is Required.',
        );
        $this->validate($request, array(
            'area_id' => 'required',
            'subArea_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $subarea = SubArea::find($id);

        $subarea->subArea_name = $request->subArea_name;
        $subarea->area_id = $request->area_id;
        $subarea->edited_by = Auth::user()->id;
        $subarea->subArea_details = $request->subArea_details;

        $subarea->save();

        return redirect('/subarea')->with('status', 'Sub Area Info Has Been Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subarea = SubArea::find($id);
        $subarea->delete();
        return redirect('/subarea')->with('status', 'Sub Area Has Been Deleted !');
    }

    //return the subcategory list of a selected category

    public function getSubArea($id){
        $subareas = SubArea::where([
                        ['area_id','=', $id]
                    ])->get();
        return $subareas;
    }
}

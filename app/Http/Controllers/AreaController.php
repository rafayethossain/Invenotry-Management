<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Area;
use App\Customer;
use App\Sale;
use App\User;

class AreaController extends Controller
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
        $areas = Area::all();
        return view('pages.area.index',compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.area.create');
    }

    //seller report
    public function sellerreport()
    {
        $area_id = Auth::user()->area_id;
        $salesmen = User::where('area_id', '=', $area_id)->whereHas('roles', function($q){
            $q->where('name', 'seller');
        })->get();
        return view('pages.areamanager.index',compact('salesmen'));
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
            'area_name.required' => 'Area Name is Required.',
        );
        $this->validate($request, array(
            'area_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $area = new Area;

        $area->area_name = $request->area_name;
        $area->added_by = Auth::user()->id;
        $area->area_details = $request->area_details;

        $area->save();

        return redirect('/area')->with('status', 'New Area Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area = Area::find($id);
        $added_by = User::withTrashed()->find($area->added_by);
        $edited_by = User::withTrashed()->find($area->edited_by);
        $manager = User::where([
                        ['area_id','=', $id]
                    ])->get();
        $salesmen = User::where([
                        ['area_id','=', $id]
                    ])->get();
        return view('pages.area.show',compact('area','added_by','edited_by','manager','salesmen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Area::find($id);
        return view('pages.area.edit',compact('area'));
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
            'area_name.required' => 'Area Name is Required.',
        );
        $this->validate($request, array(
            'area_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $area = Area::find($id);

        $area->area_name = $request->area_name;
        $area->edited_by = Auth::user()->id;
        $area->area_details = $request->area_details;

        $area->save();

        return redirect('/area')->with('status', 'Area Info Has Been Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //particular area report
    public function report($id)
    {
        $customers = Customer::where([
                        ['area_id','=', $id]
                    ])->get();
        $totalsale = [];
        foreach ($customers as $customer) {
            $sales = Sale::where([
                        ['customer_id','=', $customer->id]
                    ])->groupBy('order_id')->selectRaw('sum(total) as sum, id, order_id, sale_date, customer_id, seller_id')->get();
            array_push($totalsale, $sales);
        }

        $area = Area::find($id);

        $users = User::where([
                        ['area_id','=', $id]
                    ])->get();

        return view('pages.area.report',compact('area','users','totalsale'));
    }

    //particular area report
    public function datetodateareareport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('status', 'End Date Need to be Greater than the Start Date!');
        }
        $areareport = Area::find($request->area_id);
        $customers = Customer::where([
                        ['area_id','=', $request->area_id]
                    ])->get();
        $totalsale = [];
        foreach ($customers as $customer) {
            $sales = Sale::where([
                        ['customer_id','=', $customer->id]
                    ])->whereBetween('sale_date', [$start_date, $end_date])->groupBy('order_id')->selectRaw('sum(total) as sum, id, order_id, sale_date, customer_id, seller_id')->get();
            array_push($totalsale, $sales);
        }

        $users = User::where([
                        ['area_id','=', $areareport->id]
                    ])->get();

        $areas = Area::all();

        return view('pages.area.datetodatereport',compact('areas','areareport','users','totalsale','start_date','end_date'));
    }
}

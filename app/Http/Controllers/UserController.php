<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Area;
use App\SubArea;
use App\Expense;
use App\Sale;

class UserController extends Controller
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
        $users = User::all();
        $salesmen = User::whereHas('roles', function($q){
            $q->where('name', 'seller');
        })->get();
        return view('pages.user.index',compact('users','salesmen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $areas = Area::all();
        $subareas = SubArea::all();
        return view('pages.user.create',compact('roles','areas','subareas'));
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
            'name.required' => 'User Name is Required.',
            'role_id.required' => 'User Role is Required.',
            'mobile.required' => 'User Mobile Number is Required.',
            'email.required' => 'User Email is Required.',
            'password.required' => 'Password is Required.',
        );
        $this->validate($request, array(
            'role_id' => 'required',
            'mobile' => 'required',
            'password' => 'required|string|max:255|min:6',
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',     
        ),$messages);

        //selling area validation
        if ($request->role_id == 5) {
            $messages = array(
                'area_id.required' => 'Selling Area is Required.',
            );
            $this->validate($request, array(
                'area_id' => 'required',    
            ),$messages);
        }

        // store in the database
        $user = new User;

        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->area_id = $request->area_id;
        $user->subArea_id = $request->subArea_id;
        $user->address = $request->address;

        if(!empty($request->file('image')))
        {
            $file = $request->file('image') ;
            $image = time() . '.' . $file->getClientOriginalExtension() ;
            $destinationPath = public_path().'/images/' ;
            $file->move($destinationPath,$image);
            $user->image = $image;
        };

        $user->save();

        $role = Role::find($request->role_id);
        $user->attachRole($role);

        return redirect('/user')->with('status', 'New User Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('pages.user.show',compact('user'));
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
        $user = User::find($id);
        $roles = Role::all();

        return view('pages.user.edit',compact('user','areas','roles'));
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
            'name.required' => 'User Name is Required.',
            'role_id.required' => 'User Role is Required.',
            'mobile.required' => 'User Mobile Number is Required.',
        );
        $this->validate($request, array(
            'role_id' => 'required',
            'mobile' => 'required',
            'name' => 'required|max:255',    
        ),$messages);

        //selling area validation
        if ($request->role_id == 5) {
            $messages = array(
                'area_id.required' => 'Selling Area is Required.',
            );
            $this->validate($request, array(
                'area_id' => 'required',    
            ),$messages);
        }

        // store in the database
        $user = User::find($id);

        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->area_id = $request->area_id;
        $user->subArea_id = $request->subArea_id;
        $user->address = $request->address;

        if(!empty($request->file('image')))
        {
            $file = $request->file('image') ;
            $image = time() . '.' . $file->getClientOriginalExtension() ;
            $destinationPath = public_path().'/images/' ;
            $file->move($destinationPath,$image);
            $user->image = $image;
        };

        $user->save();

        //remove previous role 
        $previous_role = $user->roles->first();
        $user->roles()->detach($previous_role);

        //add the new role
        $role = Role::find($request->role_id);
        $user->attachRole($role);

        return redirect('/user')->with('status', 'User Info Has Been Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/user')->with('status', 'User Has Been Deleted !');
    }

    public function paymentreport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('status', 'End Date Need to be Greater than the Start Date!');
        }

        $users = User::all();
        $expense_total = [];
        foreach ($users as $user) {
            $expenses = Expense::where('user_id','=', $user->id)->whereBetween('expense_date', [$start_date, $end_date])->sum('amount');
            array_push($expense_total, $expenses);
        }
        return view('pages.user.alluserreport',compact('users','expense_total','start_date','end_date'));
    }

    public function printpaymentreport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $users = User::all();
        $expense_total = [];
        foreach ($users as $user) {
            $expenses = Expense::where('user_id','=', $user->id)->whereBetween('expense_date', [$start_date, $end_date])->sum('amount');
            array_push($expense_total, $expenses);
        }
        return view('pages.user.printpayment',compact('users','expense_total','start_date','end_date'));
    }

    //particular area report
    public function datetodatesellerreport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('status', 'End Date Need to be Greater than the Start Date!');
        }
        $user = User::find($request->seller_id);
        $sales = Sale::where([
                    ['seller_id','=', $user->id]
                ])->whereBetween('sale_date', [$start_date, $end_date])->groupBy('order_id')->selectRaw('sum(total) as sum, id, order_id, sale_date, customer_id, seller_id')->get();

        return view('pages.user.datetodatesellerreport',compact('user','sales','start_date','end_date'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Loan;
use App\User;
use DB;
use Carbon\Carbon;

class LoanController extends Controller
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
        $loans = Loan::orderBy('id', 'desc')->get();
        return view('pages.loan.index',compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('pages.loan.create',compact('users'));
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
            'date.required' => 'Date is Required.',
            'user_id.required' => 'Customer Name is Required.',
            'amount.required' => 'Income Amount is Required.',
        );
        $this->validate($request, array(
            'date' => 'required',
            'user_id' => 'required',
            'amount' => 'required|numeric',
        ),$messages);

        // store in the database
        $loan = new Loan;

        $loan->date = $request->date;
        $loan->user_id = $request->user_id;
        $loan->amount = $request->amount;
        $loan->remaining_amount = $request->amount;
        $loan->details = $request->details;

        $loan->save();

        return redirect('/loan')->with('status', 'New Loan Has Been Sanctioned !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loan = Loan::find($id);
        $payments = DB::table('loanreturns')->where('loan_id', $id)->get();
        return view('pages.loan.show',compact('loan','payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = Loan::find($id);
        $users = User::all();
        return view('pages.loan.edit',compact('loan','users'));
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
            'date.required' => 'Date is Required.',
            'user_id.required' => 'Customer Name is Required.',
            'amount.required' => 'Income Amount is Required.',
        );
        $this->validate($request, array(
            'date' => 'required',
            'user_id' => 'required',
            'amount' => 'required|numeric',
        ),$messages);

        // store in the database
        $loan = Loan::find($id);

        $loan->date = $request->date;
        $loan->user_id = $request->user_id;
        $loan->amount = $request->amount;
        $loan->details = $request->details;

        $loan->save();

        return redirect('/loan')->with('status', 'Loan Info Has Been Updated !');
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

    //loan return
    public function loanreturn()
    {
        return view('pages.loan.returnpage');
    }

    //loan return
    public function confirmloanpayment(Request $request)
    {
        //validation
        $messages = array(
            'date.required' => 'Date is Required.',
            'loan_number.required' => 'Loan Number is Required.',
            'amount.required' => 'Income Amount is Required.',
        );
        $this->validate($request, array(
            'date' => 'required',
            'loan_number' => 'required',
            'amount' => 'required|numeric',
        ),$messages);

        $loan = Loan::find($request->loan_number);
        if (empty($loan)) {
            return back()->with('status', 'Invalid Loan Number!');
        }
        $date = $request->date;
        $amount = $request->amount;
        $details = $request->details;
        return view('pages.loan.confirmpage',compact('loan','date','amount','details'));
    }

    public function loanpayment(Request $request)
    {
        //validation
        $messages = array(
            'date.required' => 'Date is Required.',
            'amount.required' => 'Income Amount is Required.',
        );
        $this->validate($request, array(
            'date' => 'required',
            'amount' => 'required|numeric',
        ),$messages);

        DB::table('loanreturns')->insert([
            ['date' => $request->date, 'loan_id' => $request->loan_number, 'amount' => $request->amount, 'details' => $request->details, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),]
        ]);

        $loan = Loan::find($request->loan_number);
        $loan->remaining_amount = $loan->remaining_amount - $request->amount;
        $loan->save();

        return redirect('/loan')->with('status', 'Loan Installment Has Been Paid !');
    }
}

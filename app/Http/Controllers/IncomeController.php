<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Income;
use App\Customer;
use App\User;
use PDF;
use Excel; 

class IncomeController extends Controller
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
        $incomes = Income::orderBy('id', 'desc')->get();
        return view('pages.income.index',compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        return view('pages.income.create',compact('customers'));
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
            'income_date.required' => 'Date is Required.',
            'purpose.required' => 'Purpose is Required.',
            'customer_id.required' => 'Customer Name is Required.',
            'amount.required' => 'Income Amount is Required.',
            'payment_type.required' => 'Payment Type is Required.',
        );
        $this->validate($request, array(
            'income_date' => 'required',
            'purpose' => 'required',
            'customer_id' => 'required',
            'amount' => 'required|numeric',
            'payment_type' => 'required',     
        ),$messages);

        if ($request->payment_type == 2) {
            $messages = array(
                'cheque_number.required' => 'Cheque Number is Required.',
            );

            $this->validate($request, array(
                'cheque_number' => 'required',     
            ),$messages);
        }

        // store in the database
        $income = new Income;

        $income->income_date = $request->income_date;
        $income->customer_id = $request->customer_id;
        $income->purpose = $request->purpose;
        $income->payment_type = $request->payment_type;
        $income->cheque_number = $request->cheque_number;
        $income->amount = $request->amount;
        $income->details = $request->details;
        $income->added_by = Auth::user()->id;

        $income->save();

        return redirect('/income')->with('status', 'New Income Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $income = Income::find($id);
        $added_by = User::withTrashed()->find($income->added_by);
        $edited_by = User::withTrashed()->find($income->edited_by);
        return view('pages.income.show',compact('income','added_by','edited_by'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $income = Income::find($id);
        $customers = Customer::all();
        return view('pages.income.edit',compact('customers','income'));
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
            'income_date.required' => 'Date is Required.',
            'purpose.required' => 'Purpose is Required.',
            'customer_id.required' => 'Customer Name is Required.',
            'amount.required' => 'Income Amount is Required.',
            'payment_type.required' => 'Payment Type is Required.',
        );
        $this->validate($request, array(
            'income_date' => 'required',
            'purpose' => 'required',
            'customer_id' => 'required',
            'amount' => 'required|numeric',
            'payment_type' => 'required',     
        ),$messages);

        // store in the database
        $income = Income::find($id);

        $income->income_date = $request->income_date;
        $income->customer_id = $request->customer_id;
        $income->purpose = $request->purpose;
        $income->payment_type = $request->payment_type;
        $income->cheque_number = $request->cheque_number;
        $income->amount = $request->amount;
        $income->details = $request->details;
        $income->edited_by = Auth::user()->id;

        $income->save();

        return redirect('/income')->with('status', 'Income Info Has Been Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $income = Income::find($id);
        $income->delete();
        return redirect('/income')->with('status', 'Income Has Been Deleted !');
    }

    //date to date income report
    public function datetodateincome(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('status', 'End Date Need to be Greater than the Start Date!');
        }

        $incomes = Income::whereBetween('income_date', [$start_date, $end_date])->get();
        return view('pages.income.datetodateincome',compact('incomes','start_date','end_date'));
    }

    //print date to date income report
    public function printincomereport(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $incomes = Income::whereBetween('income_date', [$start_date, $end_date])->get();
        return view('pages.income.printincomereport',compact('incomes','start_date','end_date'));
    }

    //pdf of date to date income report
    public function exportPDF(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $incomes = Income::whereBetween('income_date', [$start_date, $end_date])->get();
        $total_income = [];
        foreach ($incomes as $income) {
            array_push($total_income, $income->amount);
        }
        $pdf = PDF::loadView('pages.income.pdf', compact('incomes','start_date','end_date','total_income'));
        return $pdf->download('incomes.pdf');
    }

    //excel of date to date income report
    public function exportExcel(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $incomes = Income::whereBetween('income_date', [$start_date, $end_date])->get();
        $total_income = [];
        foreach ($incomes as $income) {
            array_push($total_income, $income->amount);
        }
        Excel::create('incomes', function($excel) use ($incomes, $start_date, $end_date, $total_income) {
            $excel->sheet('incomes', function($sheet) use ($incomes, $start_date, $end_date, $total_income) {
                $sheet->loadView('pages.income.excel')->with('incomes',$incomes)
                ->with('start_date',$start_date)
                ->with('end_date',$end_date)
                ->with('total_income',$total_income);
            });
        })->download('xls');
    }
}

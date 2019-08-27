<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Expense;
use App\ExpenseItem;
use App\Customer;
use App\Product;
use App\Store;
use DateTime;
use Carbon\Carbon;

class ExpenseController extends Controller
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
        $expenseitems = ExpenseItem::all();
        $expenses = Expense::orderBy('id', 'desc')->get();
        return view('pages.expense.index',compact('expenses','expenseitems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $customers = Customer::all();
        $products = Product::all();
        $expenseitems = ExpenseItem::all();
        return view('pages.expense.create',compact('expenseitems','users','customers','products'));
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
            'expense_date.required' => 'Date is Required.',
            'expense_item_id.required' => 'Purpose is Required.',
        );
        $this->validate($request, array(
            'expense_date' => 'required',
            'expense_item_id' => 'required',    
        ),$messages);

        if ($request->expense_item_id != 2) {
            $messages = array(
                'amount.required' => 'Expense Amount is Required.',
            );

            $this->validate($request, array(
                'amount' => 'required|numeric',     
            ),$messages);
        }

        // store in the database
        $expense = new Expense;

        $expense->expense_date = $request->expense_date;
        $expense->expense_item_id = $request->expense_item_id;
        $expense->customer_id = $request->customer_id;
        $expense->user_id = $request->user_id;
        $expense->details = $request->details;
        $expense->added_by = Auth::user()->id;

        if ($request->expense_item_id == 2) {
            $total_amount = [];
            for ($i=0; $i < count($request->product_id); $i++) {
                $stocks = Store::where([
                            ['product_id','=', $request->product_id[$i]],
                            ['quantity','>=',  $request->quantity[$i]]
                        ])->get();
                //sub product from store
                $stocks[0]->quantity = $stocks[0]->quantity - $request->quantity[$i];
                $stocks[0]->save();

                //sub product from product stock
                $product = Product::find($request->product_id[$i]);
                $product->product_stock = $product->product_stock - $request->quantity[$i];
                $product->save();

                $customer = Customer::find($request->customer_id);
                $amount = ceil((($product->mrp * 100 ) / ($customer->trade_price + 100)) * $request->quantity[$i]);
                array_push($total_amount,$amount);
            }
            $expense->product_id = implode("|",$request->product_id);
            $expense->quantity = implode("|",$request->quantity);
            $expense->amount = array_sum($total_amount);
        }
            
        else{
            $expense->amount = $request->amount;
        }

        $expense->save();

        return redirect('/expense')->with('status', 'New Expense Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::find($id);
        $products = [];
        if ($expense->product_id != '' ) {
            $product_ids = explode("|", $expense->product_id);
            foreach ($product_ids as $key => $value) {
                $product = Product::find($value);
                array_push($products, $product);
            }
            $quantity = explode("|", $expense->quantity);
        }

        if ($expense->customer_id != '' ) {
            $customer = Customer::find($expense->customer_id);
        }

        if ($expense->user_id != '' ) {
            $user = User::withTrashed()->find($expense->user_id);
        }

        $added_by = User::withTrashed()->find($expense->added_by);
        $edited_by = User::withTrashed()->find($expense->edited_by);
        
        return view('pages.expense.show',compact('expense','products','customer','user','added_by','edited_by','quantity'));
    }

    //print product sample expense
    public function printproductexpense($id)
    {
        $expense = Expense::find($id);
        $products = [];
        if ($expense->product_id != '' ) {
            $product_ids = explode("|", $expense->product_id);
            foreach ($product_ids as $key => $value) {
                $product = Product::find($value);
                array_push($products, $product);
            }
            $quantity = explode("|", $expense->quantity);
        }

        if ($expense->customer_id != '' ) {
            $customer = Customer::find($expense->customer_id);
        }

        if ($expense->user_id != '' ) {
            $user = User::withTrashed()->find($expense->user_id);
        }

        $added_by = User::withTrashed()->find($expense->added_by);
        $edited_by = User::withTrashed()->find($expense->edited_by);
        
        return view('pages.expense.printproductexpense',compact('expense','products','customer','user','added_by','edited_by','quantity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::find($id);
        $expenseitems = ExpenseItem::all();
        return view('pages.expense.edit',compact('expense','expenseitems'));
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
            'expense_date.required' => 'Date is Required.',
            'amount.required' => 'Expense Amount is Required.',
        );
        $this->validate($request, array(
            'expense_date' => 'required',
            'amount' => 'required|numeric',     
        ),$messages);

        // store in the database
        $expense = Expense::find($id);

        $expense->expense_date = $request->expense_date;
        $expense->amount = $request->amount;
        $expense->details = $request->details;
        $expense->edited_by = Auth::user()->id;
        $expense->superAdmin_approval = 0;

        $expense->save();

        return redirect('/expense')->with('status', 'Expense Info Has Been Updated !');
    }

    //expense approval
    public function approval($id)
    {
        $expense = Expense::find($id);
        $expense->superAdmin_approval = 1;
        $expense->save();
        return $expense;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();
        return redirect('/expense')->with('status', 'Expense Has Been Deleted !');
    }

    //daily expense report
    public function dailyreport()
    {
        $today = new DateTime();
        $today = $today->format('Y-m-d');
        $expenses = Expense::where([
                        ['expense_date','=', $today]
                    ])->get();
        return view('pages.expense-report.daily',compact('expenses'));
    }

    //weekly expense report
    public function weeklyreport()
    {
        $today = Carbon::now();   
        $lastweek = $today->copy()->subWeek();

        $today = $today->toDateString();
        $lastweek = $lastweek->toDateString();

        $expenses = Expense::whereBetween('expense_date', [$lastweek, $today])->get();
        return view('pages.expense-report.weekly',compact('expenses'));
    }

    //monthly expense report
    public function monthlyreport()
    {
        $today = Carbon::now();   
        $lastmonth = $today->copy()->subMonth();

        $today = $today->toDateString();
        $lastmonth = $lastmonth->toDateString();

        $expenses = Expense::whereBetween('expense_date', [$lastmonth, $today])->get();
        return view('pages.expense-report.monthly',compact('expenses'));
    }

    //yearly expense report
    public function yearlyreport()
    {
        $today = Carbon::now();   
        $lastyear = $today->copy()->subYear();

        $today = $today->toDateString();
        $lastyear = $lastyear->toDateString();

        $expenses = Expense::whereBetween('expense_date', [$lastyear, $today])->get();
        return view('pages.expense-report.yearly',compact('expenses'));
    }

    //particular expense report
    public function particularexpense(Request $request)
    {
        $expenseitems = ExpenseItem::all();
        $expenseItem = ExpenseItem::find($request->expense_item_id);
        $expenses = Expense::where('expense_item_id','=', $request->expense_item_id )->get();
        return view('pages.expense-report.particular',compact('expenses','expenseitems','expenseItem'));
    }

    //print particular expense report
    public function printparticularexpensereport(Request $request)
    {
        $expenseItem = ExpenseItem::find($request->expense_type);
        $expenses = Expense::where('expense_item_id','=', $request->expense_type)->get();
        return view('pages.expense-report.printparticular',compact('expenses','expenseitems','expenseItem'));
    }

    //date to date expenses report
    public function datetodateexpense(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('status', 'End Date Need to be Greater than the Start Date!');
        }
        $expenseitems = ExpenseItem::all();
        $expenses = Expense::whereBetween('expense_date', [$start_date, $end_date])->get();
        return view('pages.expense.datetodateexpense',compact('expenses','start_date','end_date','expenseitems'));
    }

    //date to date expenses report
    public function printexpensereport(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $expenseitems = ExpenseItem::all();
        $expenses = Expense::whereBetween('expense_date', [$start_date, $end_date])->get();
        return view('pages.expense.printexpensereport',compact('expenses','start_date','end_date','expenseitems'));
    }
}

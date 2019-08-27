<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Product;
use App\Customer;
use App\Sale;
use App\Expense;
use App\Income;
use App\Store;
use App\Loan;
use App\Purchase;
use Carbon\Carbon;
use App\DamagedProduct;
use PDF;
use Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checklogin()
    {
        if (Auth::check()) {
            return redirect()->action(
                'HomeController@index'
            );
        }
        else{
            return view('auth.login');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $customers = Customer::all();
        $users = User::all();

        $today = Carbon::now();   
        $today = $today->toDateString();

        $sales = Sale::where([
            ['sale_date','=', $today]
        ])->sum('total');

        $totalsales = Sale::where([
            ['superAdmin_approval','=', 1]
        ])->sum('total');
        $totalexpenses = Expense::where([
            ['superAdmin_approval','=', 1]
        ])->sum('amount');
        $totalincomes = Income::sum('amount');
        $receivable = $totalsales - $totalincomes;

        $expenses = Expense::where([
            ['expense_date','=', $today], ['superAdmin_approval','=', 1]
        ])->sum('amount');

        $incomes = Income::where([
            ['income_date','=', $today]
        ])->sum('amount');

        $damage = DamagedProduct::all()->sum('amount');

        $loanReceivable = Loan::all()->sum('remaining_amount');

        $stores = Store::all();

        $remainsunsold = [];
        foreach ($stores as $store) {
            $sum = $store->quantity * $store->purchase_price;
            array_push($remainsunsold, $sum);
        }

        $remainingproduct = array_sum($remainsunsold);

        $purchases = Purchase::all();
        $totalpurchase = [];
        foreach ($purchases as $purchase) {
            $sum = $purchase->quantity * $purchase->purchase_price;
            array_push($totalpurchase, $sum);
        }
        $totalpurchaseprice = array_sum($totalpurchase);

        $solditem = $totalpurchaseprice - $remainingproduct;

        $incomeamount = $totalsales - ($solditem - $damage);

        $netprofit = $incomeamount - ($totalexpenses + $damage);

        return view('home',compact('products','customers','users','sales','expenses','incomes','totalsales','totalincomes','totalexpenses','receivable','remainingproduct','totalpurchaseprice','solditem','incomeamount','netprofit','loanReceivable','damage'));
    }

    public function allreport(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('status', 'End Date Need to be Greater than the Start Date!');
        }


        $totalsales = Sale::where([
            ['superAdmin_approval','=', 1]
        ])->whereBetween('sale_date', [$start_date, $end_date])->sum('total');

        $totalexpenses = Expense::where([
            ['superAdmin_approval','=', 1]
        ])->whereBetween('expense_date', [$start_date, $end_date])->sum('amount');

        $totalincomes = Income::whereBetween('income_date', [$start_date, $end_date])->sum('amount');

        $receivable = $totalsales - $totalincomes;


        $damage = DamagedProduct::whereBetween('date', [$start_date, $end_date])->sum('amount');

        $loanReceivable = Loan::all()->sum('remaining_amount');

        $stores = Store::whereBetween('purchase_date', [$start_date, $end_date])->get();

        $remainsunsold = [];
        foreach ($stores as $store) {
            $sum = $store->quantity * $store->purchase_price;
            array_push($remainsunsold, $sum);
        }

        $remainingproduct = array_sum($remainsunsold);

        $purchases = Purchase::whereBetween('purchase_date', [$start_date, $end_date])->get();
        $totalpurchase = [];
        foreach ($purchases as $purchase) {
            $sum = $purchase->quantity * $purchase->purchase_price;
            array_push($totalpurchase, $sum);
        }
        $totalpurchaseprice = array_sum($totalpurchase);

        $solditem = $totalpurchaseprice - $remainingproduct;

        $incomeamount = $totalsales - ($solditem - $damage);

        $netprofit = $incomeamount - ($totalexpenses + $damage);

        return view('allreport',compact('products','customers','users','sales','expenses','incomes','totalsales','totalincomes','totalexpenses','receivable','remainingproduct','totalpurchaseprice','solditem','incomeamount','netprofit','loanReceivable','damage','start_date','end_date'));
    }

    //reset password form
    public function showChangePasswordForm(){
        return view('auth.changepassword');
    }

    //reset password
    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not match with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be the same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->action(
            'HomeController@index'
        )->with("success","Password changed successfully !");

    }

    //quotation
    public function quotation(){
        return view('pages.quotation.create');
    }

    //price list
    public function pricelist(Request $request)
    {
        $trade_price = $request->trade_price;
        $products = Product::all();
        return view('pages.quotation.pricelist',compact('trade_price','products'));
    }

    //price list
    public function printquotation($id)
    {
        $trade_price = $id;
        $products = Product::all();
        return view('pages.quotation.printquotation',compact('trade_price','products'));
    }

    //price list pdf
    public function pdfquotation($id)
    {
        $trade_price = $id;
        $products = Product::all();
        $pdf = PDF::loadView('pages.quotation.pdf', compact('trade_price','products'));
        return $pdf->download('quotation.pdf');
    }

    //price list excel
    public function excelquotation($id)
    {
        $trade_price = $id;
        $products = Product::all();
        Excel::create('quotation', function($excel) use ($products, $trade_price) {
            $excel->sheet('quotation', function($sheet) use ($products, $trade_price) {
                $sheet->loadView('pages.quotation.excel')->with('products',$products)
                ->with('trade_price',$trade_price);
            });
        })->download('xls');
    }

    //check for pending items
    public function checkforpending()
    {
        $sales = Sale::where([
            ['superAdmin_approval','=', 0]
        ])->groupBy('order_id')->get();

        $expenses = Expense::where([
            ['superAdmin_approval','=', 0]
        ])->get();

        $purchases = Purchase::whereNull('purchase_price')->get();

        $data = [];
        $salecount = count($sales);
        $data += ['pendingsale' => $salecount];

        $expensecount = count($expenses);
        $data += ['pendingexpense' => $expensecount];

        $purchasecount = count($purchases);
        $data += ['pendingpurchase' => $purchasecount];
        return $data;
    }
}

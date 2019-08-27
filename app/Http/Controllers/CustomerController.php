<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use App\Area;
use App\Income;
use App\Sale;
use App\Product;
use App\Expense;
use App\User;
use PDF;
use Excel;

class CustomerController extends Controller
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
        $customers = Customer::all();
        return view('pages.customer.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::all();
        return view('pages.customer.create',compact('areas'));
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
            'customer_name.required' => 'Customer Name is Required.',
            'area_id.required' => 'Area Name is Required.',
            'trade_price.required' => 'Trade Price is Required.',
            'customer_mobile.required' => 'Customer Mobile Number is Required.',
        );
        $this->validate($request, array(
            'area_id' => 'required',
            'customer_mobile' => 'required',
            'trade_price' => 'required',
            'customer_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $customer = new Customer;

        $customer->customer_name = $request->customer_name;
        $customer->customer_mobile = $request->customer_mobile;
        $customer->customer_email = $request->customer_email;
        $customer->area_id = $request->area_id;
        $customer->trade_price = $request->trade_price;
        $customer->added_by = Auth::user()->id;
        $customer->customer_address = $request->customer_address;

        $customer->save();

        return redirect('/customer')->with('status', 'New Customer Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        $added_by = User::withTrashed()->find($customer->added_by);
        $edited_by = User::withTrashed()->find($customer->edited_by);
        return view('pages.customer.show',compact('customer','added_by','edited_by'));
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
        $customer = Customer::find($id);
        return view('pages.customer.edit',compact('customer','areas'));
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
            'customer_name.required' => 'Customer Name is Required.',
            'area_id.required' => 'Area Name is Required.',
            'trade_price.required' => 'Trade Price is Required.',
            'customer_mobile.required' => 'Customer Mobile Number is Required.',
        );
        $this->validate($request, array(
            'area_id' => 'required',
            'customer_mobile' => 'required',
            'trade_price' => 'required',
            'customer_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $customer = Customer::find($id);

        $customer->customer_name = $request->customer_name;
        $customer->customer_mobile = $request->customer_mobile;
        $customer->customer_email = $request->customer_email;
        $customer->area_id = $request->area_id;
        $customer->trade_price = $request->trade_price;
        $customer->edited_by = Auth::user()->id;
        $customer->customer_address = $request->customer_address;

        $customer->save();

        return redirect('/customer')->with('status', 'Customer Info Has Been Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect('/customer')->with('status', 'Customer Has Been Deleted !');
    }

    //individual customer transaction report
    public function report($id)
    {
        $customer = Customer::find($id);
        $incomes = Income::where('customer_id','=', $id )->get();
        $sales = Sale::where('customer_id','=', $id)->groupBy('order_id')->get();
        $sum = [];
        
        foreach ($sales as $sale) {
            $sale_total = 0;
            $particular_sales = Sale::where('order_id','=', $sale->order_id)->get();
            foreach ($particular_sales as $particular_sale) {
                
                $trade_price = $particular_sale->total;
                $sale_total = $sale_total + $trade_price;
                
            }
            array_push($sum, $sale_total);
        }

        $expenses = Expense::where('customer_id','=', $id)->get();
        return view('pages.customer.report',compact('incomes','customer','sales','sum','expenses'));
    }

    //print individual customer transaction report
    public function printindividualreport($id)
    {
        $customer = Customer::find($id);
        $incomes = Income::where('customer_id','=', $id )->get();
        $sales = Sale::where('customer_id','=', $id)->groupBy('order_id')->get();
        $sum = [];
        
        foreach ($sales as $sale) {
            $sale_total = 0;
            $particular_sales = Sale::where('order_id','=', $sale->order_id)->get();
            foreach ($particular_sales as $particular_sale) {
                
                $trade_price = $particular_sale->total;
                $sale_total = $sale_total + $trade_price;
                
            }
            array_push($sum, $sale_total);
        }

        $expenses = Expense::where('customer_id','=', $id)->get();
        return view('pages.customer.printindividualreport',compact('incomes','customer','sales','sum','expenses'));
    }

    //pdf individual customer transaction report
    public function pdfIndividualReport($id)
    {
        $customer = Customer::find($id);
        $incomes = Income::where('customer_id','=', $id )->get();
        $income_total = [];
        foreach ($incomes as $income) {
            array_push($income_total, $income->amount);
        }
        $sales = Sale::where('customer_id','=', $id)->groupBy('order_id')->get();
        $sum = [];
        
        foreach ($sales as $sale) {
            $sale_total = 0;
            $particular_sales = Sale::where('order_id','=', $sale->order_id)->get();
            foreach ($particular_sales as $particular_sale) {
                
                $trade_price = $particular_sale->total;
                $sale_total = $sale_total + $trade_price;
                
            }
            array_push($sum, $sale_total);
        }
        $remaining = array_sum($sum) - array_sum($income_total);
        $expenses = Expense::where('customer_id','=', $id)->get();
        $pdf = PDF::loadView('pages.customer.individualpdf', compact('incomes','customer','sales','sum','expenses','remaining'));
        return $pdf->download($customer->customer_name .'.pdf');
    }

    //pdf individual customer transaction report
    public function excelIndividualReport($id)
    {
        $customer = Customer::find($id);
        $incomes = Income::where('customer_id','=', $id )->get();
        $income_total = [];
        foreach ($incomes as $income) {
            array_push($income_total, $income->amount);
        }
        $sales = Sale::where('customer_id','=', $id)->groupBy('order_id')->get();
        $sum = [];
        
        foreach ($sales as $sale) {
            $sale_total = 0;
            $particular_sales = Sale::where('order_id','=', $sale->order_id)->get();
            foreach ($particular_sales as $particular_sale) {
                
                $trade_price = $particular_sale->total;
                $sale_total = $sale_total + $trade_price;
                
            }
            array_push($sum, $sale_total);
        }
        $remaining = array_sum($sum) - array_sum($income_total);
        
        Excel::create($customer->customer_name, function($excel) use ($incomes, $customer, $sales, $sum, $remaining) {
            $excel->sheet($customer->customer_name, function($sheet) use ($incomes, $customer, $sales, $sum, $remaining) {
                $sheet->loadView('pages.customer.excel')->with('incomes',$incomes)
                ->with('customer',$customer)
                ->with('sales',$sales)
                ->with('sum',$sum)
                ->with('remaining',$remaining);
            });
        })->download('xls');
    }

    //autocomplete search of customer
    public function autocompletesearch(Request $request)
    {
        $query = $request->get('term','');
                
        $customers = Customer::where('customer_name','LIKE','%'.$query.'%')
                            ->get();

        $results=array();                    
        
        if(count($customers ) > 0){
            foreach ($customers  as $customer) {
                $results[] = [ 'id' => $customer['id'], 'text' => $customer['customer_name']];                  
            }
            return response()->json($results);
        }
        else{
            $data[] = 'Nothing Found';
            return $data;
        }
    }

    //all customer transaction report
    public function allcustomerreport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('status', 'End Date Need to be Greater than the Start Date!');
        }

        $customers = Customer::all();
        $income_total = [];
        $sale_total = [];
        $expense_total = [];
        foreach ($customers as $customer) {
            $incomes = Income::where('customer_id','=', $customer->id )->whereBetween('income_date', [$start_date, $end_date])->sum('amount');
            $sales = Sale::where('customer_id','=', $customer->id)->whereBetween('sale_date', [$start_date, $end_date])->sum('total');
            $expenses = Expense::where('customer_id','=', $customer->id)->whereBetween('expense_date', [$start_date, $end_date])->sum('amount');

            array_push($income_total, $incomes);
            array_push($sale_total, $sales);
            array_push($expense_total, $expenses);
        }
        return view('pages.customer.allcustomerreport',compact('income_total','customers','sale_total','expense_total','start_date','end_date'));
    }

    //print of all customer report
    public function printallcustomerreport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $customers = Customer::all();
        $income_total = [];
        $sale_total = [];
        $expense_total = [];
        foreach ($customers as $customer) {
            $incomes = Income::where('customer_id','=', $customer->id )->whereBetween('income_date', [$start_date, $end_date])->sum('amount');
            $sales = Sale::where('customer_id','=', $customer->id)->whereBetween('sale_date', [$start_date, $end_date])->sum('total');
            $expenses = Expense::where('customer_id','=', $customer->id)->whereBetween('expense_date', [$start_date, $end_date])->sum('amount');

            array_push($income_total, $incomes);
            array_push($sale_total, $sales);
            array_push($expense_total, $expenses);
        }
        return view('pages.customer.printcustomerreport',compact('income_total','customers','sale_total','expense_total','start_date','end_date'));
    }

    //pdf of all customer report
    public function exportPDFallcustomerreport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $customers = Customer::all();
        $income_total = [];
        $sale_total = [];
        $expense_total = [];
        foreach ($customers as $customer) {
            $incomes = Income::where('customer_id','=', $customer->id )->whereBetween('income_date', [$start_date, $end_date])->sum('amount');
            $sales = Sale::where('customer_id','=', $customer->id)->whereBetween('sale_date', [$start_date, $end_date])->sum('total');
            $expenses = Expense::where('customer_id','=', $customer->id)->whereBetween('expense_date', [$start_date, $end_date])->sum('amount');

            array_push($income_total, $incomes);
            array_push($sale_total, $sales);
            array_push($expense_total, $expenses);
        }
        $pdf = PDF::loadView('pages.customer.allpdf', compact('income_total','customers','sale_total','expense_total','start_date','end_date'));
        return $pdf->download('customers.pdf');
    }

    //excel of all customer report
    public function exportExcelallcustomerreport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $customers = Customer::all();
        $income_total = [];
        $sale_total = [];
        $expense_total = [];
        foreach ($customers as $customer) {
            $incomes = Income::where('customer_id','=', $customer->id )->whereBetween('income_date', [$start_date, $end_date])->sum('amount');
            $sales = Sale::where('customer_id','=', $customer->id)->whereBetween('sale_date', [$start_date, $end_date])->sum('total');
            $expenses = Expense::where('customer_id','=', $customer->id)->whereBetween('expense_date', [$start_date, $end_date])->sum('amount');

            array_push($income_total, $incomes);
            array_push($sale_total, $sales);
            array_push($expense_total, $expenses);
        }
        Excel::create('customers', function($excel) use ($income_total, $customers, $sale_total, $expense_total, $start_date, $end_date) {
            $excel->sheet('customers', function($sheet) use ($income_total, $customers, $sale_total, $expense_total, $start_date, $end_date) {
                $sheet->loadView('pages.customer.allexcel')->with('income_total',$income_total)
                ->with('customers',$customers)
                ->with('sale_total',$sale_total)
                ->with('expense_total',$expense_total)
                ->with('end_date',$end_date)
                ->with('start_date',$start_date);
            });
        })->download('xls');
    }   
}

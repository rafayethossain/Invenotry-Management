<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Sale;
use App\Product;
use App\Store;
use Carbon\Carbon;
use DB;
use PDF;
use Excel;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::orderBy('id', 'desc')->groupBy('order_id')->selectRaw('sum(total) as sum, id, order_id, sale_date, customer_id, seller_id, trade_price, tp_amount, superAdmin_approval')->get();
        return view('pages.sale.index',compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    //add sale from order
    public function OrderToSale($id)
    {
        $orders = Order::where([
                        ['order_id','=', $id]
                    ])->get();
        $stocks =[];
        foreach ($orders as $order) {
            $product = Product::find($order->product_id);
            array_push($stocks,$product->product_stock);
            $invoice = 'TI'.$order->customer_id . time();
        }
        return view('pages.sale.order2sale',compact('orders','id','stocks','invoice'));
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
            'sale_date.required' => 'Date is Required.',
        );
        $this->validate($request, array(
            'sale_date' => 'required',   
        ),$messages);

        // store in the database
        $count = 0;
        $list = [];
        for ($i=0; $i < count($request->product_id); $i++) {            
            $product = Product::find($request->product_id[$i]);
            if ($product->product_stock - $request->quantity[$i] < 0) {
                $count++;
                array_push($list,$product->product_name);
            }
        }
        if ($count > 0) {
            return view('pages.sale.insufficient',compact('list'));
        }

        DB::table('orders')->where('order_id', $request->order_id)->update(['status' => 1]);

        for ($i=0; $i < count($request->product_id); $i++) { 

            $product = Product::find($request->product_id[$i]);
            
            $storage = [];
            $quantity = [];
            $sum = [];
            $sale = new Sale;
            $sale->sale_date = $request->sale_date;
            $sale->order_id = $request->order_id;
            $sale->customer_id = $request->customer_id;
            $sale->seller_id = $request->seller_id;
            $sale->trade_price = $request->trade_price[$i];
            $sale->product_id = $request->product_id[$i];
            $sale->invoice_no = $request->invoice_no;

            $tp_amount = ceil((($product->mrp * 100 ) / ($request->trade_price[$i] + 100)));
            $sale->total = $tp_amount * $request->quantity[$i];
            $sale->tp_amount = $tp_amount;
            $sale->quantity = $request->quantity[$i];
            $sale->save();
        }

        return redirect('/sale')->with('status', 'New sale Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales = Sale::where([
                        ['order_id','=', $id]
                    ])->get();
        return view('pages.sale.show',compact('sales','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Sale::find($id);
        return view('pages.sale.edit',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $sales = Sale::where([
                        ['order_id','=', $id]
                    ])->get();

        if ($sales[0]->superAdmin_approval == 1) {
            return ['The sale was already approved'];
        }

        foreach ($sales as $sale) {

            $storage = [];
            $quantity = [];
            $sum = [];

            $product = Product::find($sale->product_id);
            $product->product_stock = $product->product_stock - $sale->quantity;
            $product->save();

            $stocks = Store::where([
                        ['product_id','=', $sale->product_id],
                        ['quantity','!=', 0]
                    ])->get();
            
            if ($sale->quantity <= $stocks[0]->quantity) {
                $stocks[0]->quantity = $stocks[0]->quantity - $sale->quantity;
                $stocks[0]->save();
                array_push($storage,$stocks[0]->id);
                array_push($quantity,$sale->quantity);
                $sale->store_id = implode("|",$storage);
                $sale->quantity = implode("|",$quantity);
                $sale->superAdmin_approval = 1;

                $sale->save();

                DB::table('orders')->where('order_id', $sale->order_id)->update(['status' => 1]);
            }
            else {
                $required_quantity = $sale->quantity;
                foreach ($stocks as $stock) {
                    $remaining = $required_quantity - $stock->quantity;
                    if ($remaining <= 0 ) {
                        //$final_quantity = $stock->quantity - $required_quantity;
                        $stock->quantity = $stock->quantity - $required_quantity;
                        $stock->save();

                        array_push($storage,$stock->id);
                        array_push($quantity,$required_quantity);

                        $sale->store_id = implode("|",$storage);
                        $sale->quantity = implode("|",$quantity);
                        $sale->superAdmin_approval = 1;
                        $sale->save();
                        DB::table('orders')->where('order_id', $sale->order_id)->update(['status' => 1]);
                        break;
                    }
                    else{
                        $new_required = $required_quantity - $stock->quantity;
                        $sellable = $required_quantity - $new_required;
                        $stock->quantity = $stock->quantity - $sellable;
                        $stock->save();
                        array_push($storage,$stock->id);
                        array_push($quantity,$sellable);
                        
                        $required_quantity = $new_required;
                    }
                }
            }
        }
        
        return ['You have approved this sale'];
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

    //daily sales report
    public function dailysales()
    {
        $today = Carbon::now();   
        $today = $today->toDateString();

        $sales = Sale::where([
                        ['sale_date','=', $today]
                    ])->groupBy('order_id')->selectRaw('sum(total) as sum, id, order_id, sale_date, customer_id, seller_id')->get();

        return view('pages.sale.dailysales',compact('sales'));
    }

    //weekly sales report
    public function weeklysales()
    {
        $today = Carbon::now();   
        $lastweek = $today->copy()->subWeek();

        $today = $today->toDateString();
        $lastweek = $lastweek->toDateString();

        $sales = Sale::whereBetween('sale_date', [$lastweek, $today])->groupBy('order_id')->selectRaw('sum(total) as sum, id, order_id, sale_date, customer_id, seller_id')->get();
        return view('pages.sale.weeklysales',compact('sales'));
    }

    //monthly sales report
    public function monthlysales()
    {
        $today = Carbon::now();   
        $lastmonth = $today->copy()->subMonth();

        $today = $today->toDateString();
        $lastmonth = $lastmonth->toDateString();

        $sales = Sale::whereBetween('sale_date', [$lastmonth, $today])->groupBy('order_id')->selectRaw('sum(total) as sum, id, order_id, sale_date, customer_id, seller_id')->get();
        return view('pages.sale.monthlysales',compact('sales'));
    }

    //date to date sales report
    public function datetodatesale(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('status', 'End Date Need to be Greater than the Start Date!');
        }

        $sales = Sale::whereBetween('sale_date', [$start_date, $end_date])->groupBy('order_id')->selectRaw('sum(total) as sum, id, order_id, sale_date, customer_id, seller_id')->get();
        return view('pages.sale.datetodatesale',compact('sales','start_date','end_date'));
    }

    //print date to date sales report
    public function printsalereport(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $sales = Sale::whereBetween('sale_date', [$start_date, $end_date])->groupBy('order_id')->selectRaw('sum(total) as sum, id, order_id, sale_date, customer_id, seller_id')->get();
        return view('pages.sale.printsalereport',compact('sales','start_date','end_date'));
    }

    //print particular sale 
    public function print($id)
    {
        $sales = Sale::where([
                        ['order_id','=', $id]
                    ])->get();
        return view('pages.sale.print',compact('sales','id'));
    }

    //pdf of particular sale 
    public function exportPDF($id)
    {
        $sales = Sale::where([
                        ['order_id','=', $id]
                    ])->get();
        $sale_total = [];
        foreach ($sales as $sale) {
            array_push($sale_total, $sale->total);
        }
        $pdf = PDF::loadView('pages.sale.pdf', compact('sales','id','sale_total'));
        return $pdf->download($id.'.pdf');
    }

    //excel of particular sale 
    public function exportExcel($id)
    {
        $sales = Sale::where([
                        ['order_id','=', $id]
                    ])->get();
        $sale_total = [];
        foreach ($sales as $sale) {
            array_push($sale_total, $sale->total);
        }
        Excel::create('sale', function($excel) use ($sales, $id, $sale_total) {
            $excel->sheet('sale', function($sheet) use ($sales, $id, $sale_total) {
                $sheet->loadView('pages.sale.excel')->with('sales',$sales)
                ->with('id',$id)
                ->with('sale_total',$sale_total);
            });
        })->download('xls');
    }
}

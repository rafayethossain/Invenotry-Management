<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\Customer;
use App\Product;
use App\Sale;

class OrderController extends Controller
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
        $orders = Order::orderBy('id', 'desc')->groupBy('order_id')->get();
        return view('pages.order.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('pages.order.create',compact('customers','products'));
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
            'order_date.required' => 'Date is Required.',
            'customer_id.required' => 'Customer Name is Required.',
        );
        $this->validate($request, array(
            'order_date' => 'required',
            'customer_id' => 'required',   
        ),$messages);
        // store in the database

        $order_id = $request->customer_id . time();
        $count = count($request->product_id);

        for ($i=0; $i < $count ; $i++) { 

            $order =  new Order;
            $order->order_id = $order_id;
            $order->order_date = $request->order_date;
            $order->customer_id = $request->customer_id;
            $order->product_id = $request->product_id[$i];
            $order->quantity = $request->quantity[$i];
            $order->seller_id = Auth::user()->id;

            $order->save();
        }
        

        return redirect('/order/create')->with('status', 'Order Has Been Made !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders = Order::where([
                        ['order_id','=', $id]
                    ])->get();

        $sales = Sale::where([
                        ['order_id','=', $id]
                    ])->get();
        return view('pages.order.show',compact('orders','id','sales'));
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
    public function destroy($id)
    {
        //
    }
}

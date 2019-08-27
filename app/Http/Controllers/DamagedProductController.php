<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DamagedProduct;
use App\Product;
use App\Customer;
use App\Store;
use App\Purchase;
use App\Sale;
use App\Income;

class DamagedProductController extends Controller
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
        $damagedproducts = DamagedProduct::orderBy('id', 'desc')->get();
        return view('pages.damagedproduct.index',compact('damagedproducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('pages.damagedproduct.create',compact('products','customers'));
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
            'product_id.required' => 'Product Name is Required.',
            'quantity.required' => 'Quantity is Required.',
            'damage_type.required' => 'Damage Type is Required.',
        );
        $this->validate($request, array(
            'date' => 'required',
            'product_id' => 'required',
            'damage_type' => 'required',
            'quantity' => 'required|numeric',   
        ),$messages);

        if ($request->damage_type == 1) {
            $product = Product::find($request->product_id);
            $stores = Store::where([
                        ['quantity','>=', $request->quantity],
                        ['product_id','=', $request->product_id]
                    ])->get();
            $product->product_stock = $product->product_stock - $request->quantity;
            $product->save();
            $stores[0]->quantity = $stores[0]->quantity - $request->quantity;
            $stores[0]->save();

            $damagedproduct = New DamagedProduct;

            $damagedproduct->date = $request->date;
            $damagedproduct->product_id = $request->product_id;
            $damagedproduct->damage_type = $request->damage_type;
            $damagedproduct->quantity = $request->quantity;
            $damagedproduct->amount = $stores[0]->purchase_price * $request->quantity;
            $damagedproduct->added_by = Auth::user()->id;
            $damagedproduct->details = $request->details;

            $damagedproduct->save();
        }
        elseif ($request->damage_type == 2) {
            $sales = Sale::where([
                        ['invoice_no','=', $request->invoice_no],
                        ['product_id','=', $request->product_id]
                    ])->get();

            if ($sales->isEmpty() ) {
                return back()->with('status', 'Invalid Product or Invoice Number!');
            }

            foreach ($sales as $sale) {
                $store_id = explode("|",$sale->store_id);
                $product_quantity = explode("|",$sale->quantity);
            }

            if (array_sum($product_quantity) < $request->quantity) {
                return back()->with('status', 'Invalid Quantity. Sold Quantity is Less than the Damaged Quantity !');
            }

            $store = Store::find($store_id[0]);

            $damagedproduct = New DamagedProduct;

            $damagedproduct->date = $request->date;
            $damagedproduct->product_id = $request->product_id;
            $damagedproduct->damage_type = $request->damage_type;
            $damagedproduct->quantity = $request->quantity;
            $damagedproduct->amount = $store->purchase_price * $request->quantity;
            $damagedproduct->added_by = Auth::user()->id;
            $damagedproduct->details = $request->details;

            $damagedproduct->save();

            $tp_amount = $sales[0]->tp_amount;
            $income = new Income;

            $income->income_date = $request->date;
            $income->customer_id = $sales[0]->customer_id;
            $income->purpose = 'Returned Product (Damaged)';
            $income->payment_type = 1;
            $income->amount = $tp_amount * $request->quantity;
            $income->details = $request->details;
            $income->added_by = Auth::user()->id;

            $income->save();
        }

        else{

            $purchase = Purchase::where([
                        ['invoice_no','=', $request->purchase_invoice],
                        ['product_id','=', $request->product_id]
                    ])->get();

            $store = Store::find($purchase[0]->id);

            if ( empty($store) ) {
                return back()->with('status', 'Invalid Invoice Number!');
            }

            $product = Product::find($request->product_id);
            $product->product_stock = $product->product_stock - $request->quantity;
            $product->save();
            $store->quantity = $store->quantity - $request->quantity;
            $store->save();

            $damagedproduct = New DamagedProduct;

            $damagedproduct->date = $request->date;
            $damagedproduct->product_id = $request->product_id;
            $damagedproduct->damage_type = $request->damage_type;
            $damagedproduct->quantity = $request->quantity;
            $damagedproduct->amount = $store->purchase_price * $request->quantity;
            $damagedproduct->added_by = Auth::user()->id;
            $damagedproduct->details = $request->details;

            $damagedproduct->save();
        }

        return redirect('/damagedproduct')->with('status', 'New Damage Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

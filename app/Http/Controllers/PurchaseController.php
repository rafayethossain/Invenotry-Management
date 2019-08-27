<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Product;
use App\Store;

class PurchaseController extends Controller
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
        $purchases = Purchase::orderBy('id', 'desc')->get();
        return view('pages.purchase.index',compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('pages.purchase.create',compact('products'));
    }

    //add via barcode
    public function addviabarcode()
    {
        $products = Product::all();
        return view('pages.purchase.addviabarcode',compact('products'));
    }

    //store via barcode
    public function purchaseviabarcode(Request $request)
    {
        //validation
        $messages = array(
            'purchase_date.required' => 'Date is Required.',
            'quantity.required' => 'Quantity is Required.',
            'product_code.required' => 'Product Code is Required.',
        );
        $this->validate($request, array(
            'purchase_date' => 'required',
            'quantity' => 'required|numeric',
            'product_code' => 'required',    
        ),$messages);

        $products = Product::where([
                        ['product_code','=', $request->product_code]
                    ])->get();

        if ($products->isEmpty() ) {
            return back()->with('status', 'Invalid Product Code!');
        }

        // store in the database
        $purchase = new Purchase;

        $purchase->purchase_date = $request->purchase_date;
        $purchase->product_id = $products[0]->id;
        $purchase->quantity = $request->quantity;
        $purchase->invoice_no = $request->invoice_no;

        $purchase->save();

        //save the purchase as store
        $store = new Store;

        $store->purchase_date = $request->purchase_date;
        $store->product_id = $products[0]->id;
        $store->quantity = $request->quantity;

        $store->save();

        $product = Product::find($products[0]->id);
        $product->product_stock = $product->product_stock + $request->quantity;
        $product->save();

        return redirect('/purchase')->with('status', 'New Purchase Has Been Added !');
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
            'purchase_date.required' => 'Date is Required.',
            'quantity.required' => 'Quantity is Required.',
            'product_id.required' => 'Product Name is Required.',
        );
        $this->validate($request, array(
            'purchase_date' => 'required',
            'quantity' => 'required|numeric',
            'product_id' => 'required',    
        ),$messages);

        // store in the database
        $purchase = new Purchase;

        $purchase->purchase_date = $request->purchase_date;
        $purchase->product_id = $request->product_id;
        $purchase->quantity = $request->quantity;
        $purchase->invoice_no = $request->invoice_no;

        $purchase->save();

        //save the purchase as store
        $store = new Store;

        $store->purchase_date = $request->purchase_date;
        $store->product_id = $request->product_id;
        $store->quantity = $request->quantity;

        $store->save();

        $product = Product::find($request->product_id);
        $product->product_stock = $product->product_stock + $request->quantity;
        $product->save();

        return redirect('/purchase')->with('status', 'New Purchase Has Been Added !');
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
        $purchase = Purchase::find($id);
        return view('pages.purchase.edit',compact('purchase'));
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
            'purchase_price.required' => 'Purchase Price is Required.',
        );
        $this->validate($request, array(
            'purchase_price' => 'required|numeric',   
        ),$messages);

        // store in the database
        $purchase = Purchase::find($id);

        $purchase->purchase_price = $request->purchase_price;

        $purchase->save();

        //add purchase price to store table as well
        $store = Store::find($id);
        $store->purchase_price = $request->purchase_price;
        $store->save();

        return redirect('/purchase')->with('status', 'Product Purchase Price Has Been Added !');
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

    //date to date purchase report
    public function purchasereport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('status', 'End Date Need to be Greater than the Start Date!');
        }
        $purchases = Purchase::whereBetween('purchase_date', [$start_date, $end_date])->get();
        return view('pages.purchase.report',compact('purchases','start_date','end_date'));
    }
}

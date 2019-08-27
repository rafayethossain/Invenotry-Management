<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ReturnedProduct;
use App\Customer;
use App\Product;
use App\Sale;
use App\Store;
use App\Income;
use App\User;

class ReturnedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnedproducts = ReturnedProduct::orderBy('id', 'desc')->get();
        return view('pages.returnedproduct.index',compact('returnedproducts'));
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
        return view('pages.returnedproduct.create',compact('products','customers'));
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
            'invoice_no.required' => 'Invoice Number is Required.',
        );
        $this->validate($request, array(
            'date' => 'required',
            'invoice_no' => 'required',   
        ),$messages);
        $total_amount = [];
        $customer_id;
        for ($i=0; $i < count($request->product_id); $i++) {
            $sales = Sale::where([
                ['invoice_no','=', $request->invoice_no],
                ['product_id','=', $request->product_id[$i]]
            ])->get();

            if ($sales->isEmpty() ) {
                return back()->with('status', 'Invalid Product or Invoice Number!');
            }

            foreach ($sales as $sale) {
                $store_id = explode("|",$sale->store_id);
                $product_quantity = explode("|",$sale->quantity);
            }

            if (array_sum($product_quantity) < $request->quantity[$i]) {
                return back()->with('status', 'Invalid Quantity. Sold Quantity is Less than the Returned Quantity !');
            }

            $store = Store::find($store_id[0]);
            $store->quantity = $store->quantity + $request->quantity[$i];
            $store->save();

            $product = Product::find($request->product_id[$i]);
            $product->product_stock = $product->product_stock + $request->quantity[$i];
            $product->save();

        // store in the database
            $returnedproduct = new ReturnedProduct;

            $returnedproduct->date = $request->date;
            $returnedproduct->product_id = $request->product_id[$i];
            $returnedproduct->customer_id = $sales[0]->customer_id;
            $returnedproduct->quantity = $request->quantity[$i];
            $returnedproduct->added_by = Auth::user()->id;
            $returnedproduct->details = $request->details;

            $returnedproduct->save();

            $tp_amount = $sales[0]->tp_amount;
            $amount = $tp_amount * $request->quantity[$i];
            array_push($total_amount,$amount);

            $customer_id = $sales[0]->customer_id;
        }

        $income = new Income;

        $income->income_date = $request->date;
        $income->customer_id = $customer_id;
        $income->purpose = 'Returned Product';
        $income->payment_type = 1;
        $income->amount = array_sum($total_amount);
        $income->details = $request->details;
        $income->added_by = Auth::user()->id;

        $income->save();

        return redirect('/returnedproduct')->with('status', 'New Return Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $returnedproduct = ReturnedProduct::find($id);
        $added_by = User::withTrashed()->find($returnedproduct->added_by);
        $edited_by = User::withTrashed()->find($returnedproduct->edited_by);
        return view('pages.returnedproduct.show',compact('returnedproduct','added_by','edited_by'));
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

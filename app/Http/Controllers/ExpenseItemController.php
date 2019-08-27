<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpenseItem;

class ExpenseItemController extends Controller
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
        $expenseitems = ExpenseItem::orderBy('id', 'desc')->get();
        return view('pages.expense-item.index',compact('expenseitems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.expense-item.create');
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
            'name.required' => 'Item Name is Required.',
        );
        $this->validate($request, array(
            'name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $expenseitem = new ExpenseItem;

        $expenseitem->name = $request->name;
        $expenseitem->details = $request->details;

        $expenseitem->save();

        return redirect('/expenseitem')->with('status', 'New Expense Item Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expenseitem = ExpenseItem::find($id);
        return view('pages.expense-item.show',compact('expenseitem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expenseitem = ExpenseItem::find($id);
        return view('pages.expense-item.edit',compact('expenseitem'));
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
            'name.required' => 'Item Name is Required.',
        );
        $this->validate($request, array(
            'name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $expenseitem = ExpenseItem::find($id);

        $expenseitem->name = $request->name;
        $expenseitem->details = $request->details;

        $expenseitem->save();

        return redirect('/expenseitem')->with('status', 'Expense Item Info Has Been Updated !');
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

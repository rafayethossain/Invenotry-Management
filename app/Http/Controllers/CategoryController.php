<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\User;

class CategoryController extends Controller
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
        $categories = Category::all();
        return view('pages.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.category.create');
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
            'category_name.required' => 'Category Name is Required.',
        );
        $this->validate($request, array(
            'category_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $category = new Category;

        $category->category_name = $request->category_name;
        $category->added_by = Auth::user()->id;
        $category->category_details = $request->category_details;

        $category->save();

        return redirect('/category')->with('status', 'New Category Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        $added_by = User::find($category->added_by);
        $edited_by = User::find($category->edited_by);
        return view('pages.category.show',compact('category','added_by','edited_by'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('pages.category.edit',compact('category'));
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
            'category_name.required' => 'Category Name is Required.',
        );
        $this->validate($request, array(
            'category_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $category = Category::find($id);

        $category->category_name = $request->category_name;
        $category->edited_by = Auth::user()->id;
        $category->category_details = $request->category_details;

        $category->save();

        return redirect('/category')->with('status', 'Category Info Has Been Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->subcategory()->delete();
        $category->delete();
        return redirect('/category')->with('status', 'Category Has Been Deleted !');
    }
}

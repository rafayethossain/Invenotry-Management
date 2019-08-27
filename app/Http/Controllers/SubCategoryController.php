<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SubCategory;
use App\Category;
use App\User;

class SubCategoryController extends Controller
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
        $subcategories = SubCategory::all();
        return view('pages.subCategory.index',compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.subCategory.create',compact('categories'));
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
            'subCategory_name.required' => 'Sub Category Name is Required.',
            'category_id.required' => 'Category Name is Required.',
        );
        $this->validate($request, array(
            'category_id' => 'required',
            'subCategory_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $subcategory = new SubCategory;

        $subcategory->subCategory_name = $request->subCategory_name;
        $subcategory->category_id = $request->category_id;
        $subcategory->added_by = Auth::user()->id;
        $subcategory->subCategory_details = $request->subCategory_details;

        $subcategory->save();

        return redirect('/subcategory')->with('status', 'New Sub Category Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = SubCategory::find($id);
        $added_by = User::withTrashed()->find($subcategory->added_by);
        $edited_by = User::withTrashed()->find($subcategory->edited_by);
        return view('pages.subCategory.show',compact('subcategory','added_by','edited_by'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $subcategory = SubCategory::find($id);
        return view('pages.subCategory.edit',compact('subcategory','categories'));
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
            'subCategory_name.required' => 'Sub Category Name is Required.',
            'category_id.required' => 'Category Name is Required.',
        );
        $this->validate($request, array(
            'category_id' => 'required',
            'subCategory_name' => 'required|max:255',     
        ),$messages);

        // store in the database
        $subcategory = SubCategory::find($id);

        $subcategory->subCategory_name = $request->subCategory_name;
        $subcategory->category_id = $request->category_id;
        $subcategory->edited_by = Auth::user()->id;
        $subcategory->subCategory_details = $request->subCategory_details;

        $subcategory->save();

        return redirect('/subcategory')->with('status', 'Sub Category Info Has Been Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
        return redirect('/subcategory')->with('status', 'Sub Category Has Been Deleted !');
    }
}

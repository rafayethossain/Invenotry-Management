<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Category;
use App\SubCategory;
use App\User;
use PDF;
use Excel;

class ProductController extends Controller
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
        $products = Product::all();
        return view('pages.product.index',compact('products'));
    }

    //print product stock
    public function print()
    {
        $products = Product::all();
        return view('pages.product.print',compact('products'));
    }

    //pdf of product stock
    public function exportPDF()
    {
        $products = Product::all();
        $pdf = PDF::loadView('pages.product.pdf', compact('products'));
        return $pdf->download('products.pdf');
    }

    //export of excel
    public function exportExcel()
    {
        $products = Product::all();
        
        Excel::create('products', function($excel) use ($products) {
            $excel->sheet('products', function($sheet) use ($products) {
                $sheet->loadView('pages.product.excel')->with('products',$products);
            });
        })->download('xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.product.create',compact('categories'));
    }

    //return the subcategory list of a selected category

    public function getSubCategory($id){
        $subcategories = SubCategory::where([
                        ['category_id','=', $id]
                    ])->get();
        return $subcategories;
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
            'product_name.required' => 'Product Name is Required.',
            'product_code.required' => 'Product Code is Required.',
            'category_id.required' => 'Category Name is Required.',
            'subCategory_id.required' => 'SubCategory Name is Required.',
            'mrp.required' => 'Product MRP is Required.',
        );
        $this->validate($request, array(
            'category_id' => 'required',
            'subCategory_id' => 'required',
            'product_name' => 'required|max:255',
            'product_code' => 'required|max:255|unique:products',
            'mrp' => 'required|numeric',     
        ),$messages);

        // store in the database
        $product = new Product;

        $product->product_name = $request->product_name;
        $product->product_code = $request->product_code;
        $product->category_id = $request->category_id;
        $product->subCategory_id = $request->subCategory_id;
        $product->mrp = $request->mrp;
        $product->added_by = Auth::user()->id;
        $product->product_details = $request->product_details;

        if(!empty($request->file('product_image')))
        {
            $file = $request->file('product_image') ;
            $image = time() . '.' . $file->getClientOriginalExtension() ;
            $destinationPath = public_path().'/images/products/' ;
            $file->move($destinationPath,$image);
            $product->product_image = $image;
        };

        $product->save();

        return redirect('/product')->with('status', 'New Product Has Been Added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $added_by = User::withTrashed()->find($product->added_by);
        $edited_by = User::withTrashed()->find($product->edited_by);
        return view('pages.product.show',compact('product','added_by','edited_by'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('pages.product.edit',compact('categories','product'));
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
            'product_name.required' => 'Product Name is Required.',
            'product_code.required' => 'Product Code is Required.',
            'category_id.required' => 'Category Name is Required.',
            'subCategory_id.required' => 'SubCategory Name is Required.',
            'mrp.required' => 'Product MRP is Required.',
        );
        $this->validate($request, array(
            'category_id' => 'required',
            'subCategory_id' => 'required',
            'product_name' => 'required|max:255',
            'product_code' => 'required|max:255|unique:products,product_code,'.$id,
            'mrp' => 'required|numeric',     
        ),$messages);

        // store in the database
        $product = Product::find($id);

        $product->product_name = $request->product_name;
        $product->product_code = $request->product_code;
        $product->category_id = $request->category_id;
        $product->subCategory_id = $request->subCategory_id;
        $product->mrp = $request->mrp;
        $product->edited_by = Auth::user()->id;
        $product->product_details = $request->product_details;

        if(!empty($request->file('product_image')))
        {
            $file = $request->file('product_image') ;
            $image = time() . '.' . $file->getClientOriginalExtension() ;
            $destinationPath = public_path().'/images/products/' ;
            $file->move($destinationPath,$image);
            $product->product_image = $image;
        };

        $product->save();

        return redirect('/product')->with('status', 'Product Info Has Been Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('/product')->with('status', 'Product Has Been Deleted !');
    }

    public function autocompletesearch(Request $request)
    {
        $query = $request->get('term','');
                
        $products = Product::where('product_name','LIKE','%'.$query.'%')
                            ->orWhere('product_code','LIKE','%'.$query.'%')
                            ->get();

        $results=array();                    
        
        if(count($products ) > 0){
            foreach ($products  as $product) {
                $results[] = [ 'id' => $product['id'], 'text' => $product['product_name']];                  
            }
            return response()->json($results);
        }
        else{
            $data[] = 'Nothing Found';
            return $data;
        }
    }
}

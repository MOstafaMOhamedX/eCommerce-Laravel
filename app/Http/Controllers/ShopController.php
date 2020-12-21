<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categoryName = "Products";
        if (request()->category) 
        {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            })->get();
            $categories = Category::all();
            $categoryName = optional($categories->where('slug', request()->category)->first())->name;
        }
        else 
        {
            $products = Product::inRandomOrder()->take(12)->get();
            $categories = Category::all();
        }

        
                           
        if (request()->sort == 'low_high') {
            $products = $products->sortBy('price');
        } elseif (request()->sort == 'high_low') {
            $products = $products->sortBydesc('price');
        } else {
            $products = $products;
        }
        
        
        return view('shop')->with([
            'products'  =>$products,
            'categories'=>$categories,
            'categoryName'=>$categoryName,
            ]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->inRandomOrder() ->take(4)->get();
        if ($product->quantity) {
            $stocklvl = 'In Stock';
        } else {
            $stocklvl = 'Not Avilable';
        }
        


        return view('product')->with([
            'product' => $product,
            'stocklvl' => $stocklvl,
            'mightAlsoLike' => $mightAlsoLike,
            'comments' => Comment::where('product_id',$product->id)->get(),
        ]);
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

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        
        $request->validate([
            'query' => 'required|min:3',
        ]);

        $query = $request->input('query');

        $cats = Category::where('name', 'like', "%$query%")
                           ->orWhere('slug', 'like', "%$query%")
                           ->paginate(10);

        $products = Product::search($query)->paginate(10);

        return view('search')->with([
            'products'=> $products,
            'cats'=> $cats,
            'categories' => Category::all(),
            'categoryName' => $query,
            ]);
    }
}


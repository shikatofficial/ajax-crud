<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:products',
                'price' => 'required',
                'description' => 'required',
            ],
            [
                'name.required' => 'Name is required.',
                'name.unique' => 'Name should not be same.',
                'price.required' => 'Price is required.',
                'description.required' => 'Description is required.',
            ]
        );

        $product = new Product();

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        $product->save();

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id)
     {
         $request->validate([
             'name' => 'required',
             'price' => 'required|numeric',
             'description' => 'required',
         ]);
     
         $product = Product::find($id);
     
         $product->update($request->all());
     
         return response()->json(['status' => 'success']);
     }
     


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['status' => 'success'])->with('success', 'Product deleted');
    }
}

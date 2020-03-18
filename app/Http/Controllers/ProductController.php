<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * Return all the products
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Product::all() , 200);
    }

    /**
     * Store a new Product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->name, 
            'description' => $request->description, 
            'units' => $request->units,
            'price' => $request->price,
            'image' => $request->image
        ]);
        
        return response()->json([
            'status' => (bool) $product , 
            'data' => $product ,
            'message' => $product ? 'product created' : 'Error in creating Product'
        ]);
    }

    /**
     * Upload File
     * @param Request
     * @return response if the file is uploaded
     */
    public function uploadFile(Request $request)
    {
        //check if the file field is not empty
        if ($request->hasFile('image') !== FALSE) 
        {
            # code...
            // CREATE the Image file name
            $name = time() . "_" . $request->file('image') ->getClientOriginalName();
            // Specify the path where the Image File should be stored
            $request->file('image')->move(public_path('images') , $name);
        }
        return response()->json(asset("images/$name"),201);

    }
    /**
     * Display the specified product.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product , 200);
    }
    /**
     * Update the specified product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $status = $product->update( $request->only(['name', 'description', 'units', 'price', 'image']));

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Updated!' : 'Error Updating Product'
        ]);
    }

    /**
     * adds new units to a product
     */
    public function updateUnits(Request $request, Product $product)
    {
        // get the units from seller and add it to existing units
        $product->units += $request->get('units');
        // save
        $status = $product->save();
        // response
        return response()->json([
            'status' => $status , 
            'message' => $status ? 'Products Added' : 'Error Adding Product Units'
        ]);
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $status = $product->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Deleted' : 'Error In Deleting Product'
        ]);
    }
}

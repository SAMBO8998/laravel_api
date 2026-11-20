<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'category_id'   =>'required|exists:categories,id',
        //     'name'          =>'required|string|max:255',
        //     'description'   =>'required|string|max:255',
        //     'price'         =>'required|numeric|min:0',
        //     'stock'         =>'required|integer|min:0',
        // ]);
        // $products = Product::create($data);
        // return response()->json($products, 201);
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $product = Product::create($validator->validated());
        return response()->json([
            'success' => true,
            'message' => 'Insert Successfully',
            'data'    => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    //=========== // READ មួយ============
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'category_id'   =>'required|exists:categories,id',
            'name'          =>'required|string|max:255',
            'description'   =>'required|string|max:255',
            'price'         =>'required|numeric|min:0',
            'stock'         =>'required|integer|min:0',
        ]);
        $product->update($data);
        return response()->json([
            'success'       => true,
            'message'       => 'Updated successfully',
            'data'          => $product,
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findorfail($id);
        $product->delete();
        return response()->json([
            'success'   =>true,
            'message'   =>'product deleted',
        ], 200);
    }
}
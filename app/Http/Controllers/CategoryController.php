<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // ============= READ ទាំងអស់ =============
    public function index()
    {
        return response(Category::all());      //(Category::all());  || (Category) របស់ឈ្មោះ file model
    }

    /**
     * Store a newly created resource in storage.
     */
    // =========== // CREATE =============
    public function store(Request $request)
    {
        $data = Validator::make($request->all(),[
            'name'      =>'required|string',
        ]);
        if($data->fails()){
            return response()->json([
                'success'   => false,
                'message'   => $data->errors(),
            ], 400);
        }
        $category = Category::create($data->validate());
            return response()->json([$category,
                'success'       => true,
                'message'       => 'Insert Successfully',
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    //=========== // READ មួយ============
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    //==========// UPDATE============
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'name'  => 'required|string|max:255',
        ]);
        $category->update($data);
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    //========// DELETE=========
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'message' => 'Category deleted'
        ], 200);
    }
}

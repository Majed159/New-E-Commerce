<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class Product extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title='Add Product';
        $getCategories=Category::getCategories('Admin');
        return view('admin.product.create_edit_product',compact('getCategories','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = $this ->productService->Add_Edit_product($request);
        return redirect()->route('product.index')->with('success_message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title='Edit Product';
        $product = Product::findOrFail($id);
        $getCategories=Category::getCategories('Admin');
        return view('admin.product.create_edit_product',compact('product','getCategories','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge(['id' => $id]);
        $message = $this->productService->Add_Edit_product($request);
        return redirect()->route('product.index')->with('success_message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

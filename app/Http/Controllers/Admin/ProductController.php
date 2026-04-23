<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Services\Product\ProductService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'products');
        $result = $this->productService->product();
        if ($result['status'] == "error") {
            return redirect('admin/dashboard')->with('error_message', $result['message']);
        }
        return view('admin.Product.main-page', [
            'products' => $result['products'],
            'productsModule' => $result['productsModule'],

        ]);
    }

    public  function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $status = $this->productService->updateProductStatus($data);
            return response()->json(['status' => $status,'product_id' => $data['product_id']]);
        }
    }
public function uploadImage (Request $request)
{
    if ($request->hasFile('file')) {

        $fileName = $this->productService->handleImageUpload($request->file('file'));
        return response()->json(['fileName' => $fileName]);
    }
    return response()->json(['error' => 'No file was uploaded.'],400);
}

    public function uploadVideo  (Request $request)
    {
    if ($request->hasFile('file')) {

        $fileName = $this->productService->handleVideoUpload($request->file('file'));
        return response()->json(['fileName' => $fileName]);
    }
    return response()->json(['error' => 'No file was uploaded.'],400);
    }


    public function deleteProductMainImage  ($id)
    {
        $service = new ProductService();
        $message = $service->deleteProductMainImage($id);
        return redirect('/admin/products')->with('success_message', $message);

    }


    public function deleteProductVideo($id)
    {
    $message = $this->productService->deleteProductVideo($id);
    return redirect('/admin/products')->with('success_message', $message);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Product.create_edit_product', [
            'getCategories' => Category::getCategories('Admin'),
            'title' => 'Add Product',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'product_name' => ['required', 'string', 'max:255'],
            'product_code' => ['required', 'string', 'max:255'],
            'product_color' => ['required', 'string', 'max:255'],
            'family_color' => ['required', 'string', 'max:255'],
            'group_code' => ['nullable', 'string', 'max:255'],
            'product_price' => ['required', 'numeric', 'min:0'],
            'product_discount' => ['nullable', 'numeric', 'min:0'],
            'product_gst' => ['nullable', 'numeric', 'min:0'],
            'wash_care' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'search_keywords' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'in:yes,no'],
        ]);

        $this->productService->Add_Edit_product($request);

        return redirect()->route('products.index')->with('success_message', 'Product has been created successfully');
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
        return view('admin.Product.create_edit_product', [
            'product' => Product::findOrFail($id),
            'getCategories' => Category::getCategories('Admin'),
            'title' => 'Edit Product',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'product_name' => ['required', 'string', 'max:255'],
            'product_code' => ['required', 'string', 'max:255'],
            'product_color' => ['required', 'string', 'max:255'],
            'family_color' => ['required', 'string', 'max:255'],
            'group_code' => ['nullable', 'string', 'max:255'],
            'product_price' => ['required', 'numeric', 'min:0'],
            'product_discount' => ['nullable', 'numeric', 'min:0'],
            'product_gst' => ['nullable', 'numeric', 'min:0'],
            'wash_care' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'search_keywords' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'in:yes,no'],
        ]);

        $request->merge(['id' => $id]);
        $this->productService->Add_Edit_product($request);

        return redirect()->route('products.index')->with('success_message', 'Product has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->productService->deleteProduct($id);
        return redirect('admin/products')->withErrors($result['message']);
    }
}

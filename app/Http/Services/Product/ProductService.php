<?php

namespace App\Http\Services\Product;
use App\Models\AdminsRole;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function product(){
    $products = Product::with('category')->get();

    $productsModuleCount = AdminsRole::where([
        'subAdminId' => Auth::guard('admin')->user()->id,
        'module' => 'products'
    ])->count();
    $status = "success";
    $message = "";
    $productsModule = [];
    if(Auth::guard('admin')->user()->role == "admin"){
        $productsModule =[
            'view_access' =>1,
            'edit_access' =>1,
            'full_access' =>1,

        ];
    }elseif ($productsModuleCount == 0){
        $status = "error";
        $message ="You do not have permission to access this page.";
    }else{
        $productsModule = AdminsRole::where([
            'subAdminId' => Auth::guard('admin')->user()->id,
            'module' => 'products'
        ])->first()->toArray();
    }
    return [
        "products" => $products,
        "productsModule" => $productsModule,
        "status" => $status,
        "message" => $message,
    ];
    }
    public function updateProductStatus($data)
    {
        $status =($data['status'] == "Active")?0:1;
        Product::where('id', $data['product_id'])->update(['status' => $status]);
        return $status;
    }

    public function deleteProduct($id)
    {
        Product::where('id', $id)->delete();
        $message = "Product has been deleted successfully";
        return ["message" => $message];
    }

    public function Add_Edit_product($request)
    {
    $data = $request->all();
    if (isset($data['id']) && $data['id'] != "") {
        $product = Product::find($data['id']);
        $message = "Product has been updated successfully";
    }else
    {
        $product = new Product();
        $message = "Product has been created successfully";
    }

        $product->admin_id = Auth::guard('admin')->user()->id;
        $product->admin_role = Auth::guard('admin')->user()->role;
        $product->category_id = $data['category_id'];
        $product->product_name = $data['product_name'];
        $product->product_code = $data['product_code'];
        $product->product_color = $data['product_color'];
        $product->family_color = $data['family_color'];
        $product->group_code = $data['group_code'];
        $product->product_weight = $data['product_weight'] ?? 0;
        $product->product_price = $data['product_price'] ;
        $product->product_gst = $data['product_gst'] ?? 0;

        $product->product_discount = $data['product_discount'] ?? 0;
        $product->is_featured = $data['is_featured'] ?? 'no';

        if (!empty($data['product_discount']) && $data['product_discount'] > 0) {
            $product->discount_applied_on = 'product';
            $product->product_discount_amount = ($data['product_price'] * $data['product_discount'] / 100);
        }else{
            $getCategoryDiscount = Category::select('discount')->where('id', $data['category_id'])->first();
           if ($getCategoryDiscount && $getCategoryDiscount->discount > 0) {
               $product->discount_applied_on = 'category';
               $product->product_discount = $getCategoryDiscount->discount;
               $product->product_discount_amount = ($data['product_price'] * $getCategoryDiscount->discount / 100);

           }else{
               $product->discount_applied_on = '';
               $product->product_discount_amount = 0;
           }
        }
        $product->final_price = $product->product_price - $product->product_discount_amount;


        //OPtional fileds
        $product->description = $data['description'];
        $product->wash_care = $data['wash_care'] ?? "";
        $product->search_keywords = $data['search_keywords'] ?? '';
        $product->meta_title = $data['meta_title'] ?? '';
        $product->meta_description = $data['meta_description'] ?? '';
        $product->meta_keywords = $data['meta_keywords'] ?? '';
        $product->status = 1;
        $product->main_image = $request->main_image ?? $product->main_image;
        $product->product_video = $request->product_video ?? $product->product_video;
        $product->save();

        return $product;

    }
    public function handleImageUpload($file)
    {
        $destinationPath = public_path('front/images/products');
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $imageName= time().'.'.$file->getClientOriginalExtension();
        $file->move($destinationPath, $imageName);
        return $imageName;
    }

    public function handleVideoUpload($file){
    $destinationPath = public_path('front/videos/products');
    if (!is_dir($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    $videoName= time().'.'.$file->getClientOriginalExtension();
    $file->move($destinationPath, $videoName);
    return $videoName;
    }

    public function deleteProductMainImage($id)
    {
        //GEt PRoduct main image

        $product = Product::select('main_image')->where('id', $id)->first();
        if (!$product || empty($product->main_image)) {
            return "No image found";

        }

        $image_path = public_path('front/images/products/'.$product->main_image);

        //delete product main
        if (file_exists($image_path)) {
            unlink($image_path);
        }

         //delete product video name form product table
        Product::where('id', $id)->update(['main_image' => null]);
        $message = "Product main image has been deleted successfully";
        return $message;


    }
    public function deleteProductVideo($id)
    {
        $productVideo = Product::select('product_video')->where('id', $id)->first();
        if (!$productVideo || empty($productVideo->product_video)) {
            return "No video found";
        }

        $productVideoPath = public_path('front/videos/products/'.$productVideo->product_video);

        if (file_exists($productVideoPath)){
            unlink($productVideoPath);
        }

        Product::where('id', $id)->update(['product_video' => null]);
        $message = "Product video has been deleted successfully";
        return $message;
    }

    public function validate(array $array)
    {
    }


}

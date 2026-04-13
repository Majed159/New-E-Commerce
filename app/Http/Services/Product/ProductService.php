<?php

namespace App\Http\Services\Product;
use App\Models\AdminsRole;
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
}

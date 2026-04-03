<?php

namespace App\Http\Services\Category;
use App\Models\Category;
use App\Models\AdminsRole;
use Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

use Intervention\Image\laravel\Facades\Image;

class CategoryService
{
    public function categories()
    {
        $categories = Category::with('parentcategory')->get();
        $admin =Auth::guard('admin')->user();
        $status = "success";
        $message = "";
        $categoriesModule =[];

        //Admin has full access
        if ($admin->role == "admin") {
            $categoriesModule =[
                'view_access' => 1,
                'edit_access' => 1,
                'full_access' => 1,

            ];

        } else {
            $categoriesModuleCount = AdminsRole::where([
                'subAdminId'=>$admin->id,
                    'module' =>'categories'])->count();
            if ($categoriesModuleCount == 0) {
                $status = "error";
                $message = "This user doesn't have permission to access this page";
            }else{
                $categoriesModuleCount = AdminsRole::where([
                    'subAdminId'=>$admin->id,
                    'module' =>'categories'
                ])->first()->toArray();
                $categoriesModule = $categoriesModuleCount;

            }
        }

        return[
            'categories' => $categories,
            'categoriesModule' => $categoriesModule,
            'status' => $status,
            'message' => $message
        ];
    }

    public function addEditCategory($request)
    {
        $data = $request->all();


        if (isset($data['id']) && $data['id'] != "") {
            //edit Category
            $category = Category::find($data['id']);
            $message = "Category updated successfully";
        } else {
            //add Category
            $category = new Category();

            $message = "Category added successfully";
        }

        if ($request->hasFile('category_image')) {
            $image_temp = $request->file('category_image');
            if ($image_temp->isValid()) {
                $manger = new ImageManager(new Driver());
                $image = $manger->read($image_temp);
                $extension = $image_temp->getClientOriginalExtension();
                $imageName = rand(11111, 99999) . '.' . $extension;
                $image_path = 'front/images/categories/' . $imageName;
                $image->save($image_path);
                $category->image = $imageName;

            }
        }
        // Upload Size  Chart
        if ($request->hasFile('size_chart')) {
            $size_chart_temp = $request->file('size_chart');
            if ($size_chart_temp->isValid()) {
                $manger = new ImageManager(new Driver());
                $image = $manger->read($size_chart_temp);
                $size_chart_extension = $size_chart_temp->getClientOriginalExtension();
                $size_chart_name = rand(11111, 99999) . '.' . $size_chart_extension;
                $size_chart_path = 'front/images/sizecharts/' . $size_chart_name;
                $image->save($size_chart_path);
                $category->size_chart = $size_chart_name;

            }
        }
        //for format Name and url
        $data['category_name'] = str_replace("-", " ", ucwords(strtolower($data['category_name'])));
        $data['url'] = str_replace("-", " ", strtolower($data['url']));

        $category->name = $data['category_name'];
        $parentId = $data['parentId'] ?? null;
        $category->parentId = !empty($parentId) ? (int) $parentId : null;

        //discount default
        if (empty($data['category_discount'])) {
            $data['category_discount'] = 0;
        }

        $category->discount = $data['category_discount'];
        $category->description = $data['description'];
        $category->url = $data['url'];
        $category->meta_title = $data['meta_title'] ?? null;
        $category->meta_description = $data['meta_description'] ?? null;
        $category->meta_keywords = $data['meta_keywords'] ?? null;

        //Menu Status

        $category->menu_status = !empty($data['menu_status']) ? 1 : 0;
        $category->status =1;
        $category->save();

        return $message;

    }

    public function updateCategoryStatus($data)
    {
    $status =($data['status'] == "Active") ? 0 : 1;
    Category::where('id', $data['category_id'])->update(['status' => $status]);
    return $status;
    }

    public function deleteCategory(string $id)
    {
        Category::where('id', $id)->delete();
        $message = "Category deleted successfully";
        return ['message' => $message];
    }

    public function deleteCategoryImage(  $category_id)
    {
        $categoryImage = Category::where('id', $category_id)->value('image');
        if ($categoryImage) {
            $Category_image_path = 'front/images/categories/' . $categoryImage;
            if (file_exists(public_path($Category_image_path))) {
                unlink(public_path($Category_image_path));
            }
            Category::where('id', $category_id)->update(['image' => null]);
            return ['status'=>true,'message'=>'Category Image deleted successfully !'];
        }
        return ['status'=>false,'message'=>'Category Image not found'];
    }

    public function deleteSizechartImage(  $category_id)
    {
        $sizechartImage = Category::where('id', $category_id)->value('size_chart');
        if ($sizechartImage) {
            $sizechart_image_path = 'front/images/sizecharts/' . $sizechartImage;
            if (file_exists(public_path($sizechart_image_path))) {
                unlink(public_path($sizechart_image_path));

            }
            Category::where('id', $category_id)->update(['size_chart' => null]);
            return ['status'=>true,'message'=>'Chart Image deleted successfully !'];

        }
        return ['status'=>false,'message'=>'Chart Image not found'];
    }
}

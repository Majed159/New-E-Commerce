<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Services\Category\CategoryService;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'categories');
        $result = $this->categoryService->categories();
        if ($result['status'] === 'error') {
            return redirect('admin/dashboard')->withErrors($result['message']);
        }
        return  view('admin.Category.index',
            [
                'categories' => $result['categories'],
                'categoriesModule' => $result['categoriesModule'],
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Add Category";
        $category = null;
        $categories = Category::where('status', 1)
            ->where(function ($query) {
                $query->whereNull('parentId')->orWhere('parentId', 0);
            })
            ->orderBy('name')
            ->get(['id', 'name']);
        return view('admin.Category.add_edit_category', compact('title', 'category', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
       $message =$this->categoryService->addEditCategory($request);
       return redirect()->route('categories.index')->with('success_message', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Edit Category";
        $category = Category::findOrFail($id);
        $categories = Category::where('status', 1)
            ->where(function ($query) {
                $query->whereNull('parentId')->orWhere('parentId', 0);
            })
            ->where('id', '!=', $id)
            ->orderBy('name')
            ->get(['id', 'name']);
        return view('admin.Category.add_edit_category', compact('title', 'category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
      $request->merge(['id' => $id]);
      $message=$this->categoryService->addEditCategory($request);
          return redirect()->route('categories.index')->with('success_message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $status = $this->categoryService->updateCategoryStatus($data);
        }
        return response()->json(['status' => $status ,'category_id'=>$data['category_id']]);

    }

    public function destroy(string $id)
    {
    $result = $this->categoryService->deleteCategory($id);
    return redirect()->route('categories.index')->with('success_message', $result['message']);
    }

    public function deleteCategoryImage(Request $request)
    {
        $status = $this->categoryService->deleteCategoryImage($request->category_id);
        return response()->json( $status);
    }

    public function deleteSizechartImage(Request $request)
    {
        $status = $this->categoryService->deleteSizechartImage($request->category_id);
        return response()->json( $status);
    }
}

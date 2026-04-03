@extends('admin.layout.layout')
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Categories Management</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row g-4">
                    <!--begin::Col-->
                    <div class="col-md-6">
                        <div class="card card-primary card-outline mb-4">
                            <div class="card-header">
                                <div class="card-title">
                                    {{$title}}
                                </div>
                            </div>
                            @if(Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show m-3" role='alert'>
                                    <strong >Error: </strong>{{Session::get('error_message')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button>
                                </div>
                            @endif

                            @if(Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show m-3" role='alert'>
                                    <strong >Success: </strong>{{Session::get('success_message')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button>
                                </div>
                            @endif

                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show m-3" role='alert'>
                                    <strong >Error!</strong> {!! $error !!}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button>
                                </div>
                            @endforeach












                           <form name="categoryForm" id="categoryForm" action="{{isset($category)? route('categories.update',$category->id):route('categories.store')}} " method="post" enctype="multipart/form-data">@csrf
                            @if(isset($category))
                                @method('PUT')
                            @endif
                               <div class="card-body">
                                   <div class="mb-3">
                                       <label class="form-label" for="parentId">Category Level *</label>
                                       <select class="form-select" id="parentId" name="parentId">
                                           <option value="">Main Category</option>
                                           @foreach($categories as $parent)
                                               <option value="{{ $parent->id }}" {{ old('parentId', $category?->parentId) == $parent->id ? 'selected' : '' }}>
                                                   {{ $parent->name }}
                                               </option>
                                           @endforeach
                                       </select>

                                   </div>
                                   <div class="mb-3">
                                       <label class="form-label" for="category_Name">Category Name*</label>
                                       <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name" value="{{old('$category_name',$category->name ??"")}}" >
                                   </div>
                                   <div class="mb-3">
                                       <label class="form-label" for="category_image">Category Image*</label>
                                       <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*"  >
                                       @if(!empty($category?->image))
                                           <div class="mt-2"  id="categoryImageBlock">
                                               <img src="{{asset('front/images/categories/'.$category->image)}}" width="50" alt="Category Image">
                                               <a href="javascript:void(0)" id="deleteCategoryImage" data-category-id="{{$category->id}}" class="text-danger">Delete</a>

                                           </div>

                                       @endif

                                   </div>



                                   <div class="mb-3">
                                       <label class="form-label" for="siz_chart">Size Chart</label>
                                       <input type="file" class="form-control" id="size_chart" name="size_chart"  accept="iamge/*">
                                       @if(!empty($category?->size_chart))
                                           <div class="mt-2" id="sizechartImageBlock">
                                               <img src="{{asset('front/images/sizecharts/'.$category->size_chart)}}" width="50" alt="Size Chart">
                                               <a href="javascript:void(0)" id="deleteSizeChartImage" data-category-id="{{$category->id}}" class="text-danger">Delete</a>

                                           </div>

                                       @endif

                                   </div>


                                   <div class="mb-3">
                                       <label class="form-label" for="category_discount">Category Discount *</label>
                                       <input type="text" class="form-control" id="category_discount" name="category_discount" placeholder="Enter Category Discount" value="{{old('category_discount',$category?->discount ?? " ")}}">

                                   </div>

                                   <div class="mb-3">
                                       <label class="form-label" for="url">Category Url *</label>
                                       <input type="text" class="form-control" id="url" name="url" placeholder="Enter Category Url" value="{{old('url',$category?->url ?? " ")}}">

                                   </div>

                                   <div class="mb-3">
                                       <label class="form-label" for="description">Category Description *</label>
                                       <textarea class="form-control" rows="3" id="description"  name="description" placeholder="Enter Description ">{{old('description',$category?->description)}}</textarea>

                                   </div>



                                   <div class="mb-3">
                                       <label class="form-label" for="meta_title">Meta Title *</label>
                                       <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Meta Title" value="{{old('meta_title',$category?->meta_title ?? " ")}}">


                                   </div>



                                   <div class="mb-3">
                                       <label class="form-label" for="meta_status">Meta Status *</label>
                                       <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Meta Title" value="{{old('meta_title',$category?->meta_title ?? " ")}}">


                                   </div>

                                   <div class="mb-3">
                                       <label class="form-label" for="meta_description">Meta Description *</label>
                                       <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Enter Meta Description" value="{{old('meta_description',$category?->meta_description ?? " ")}}">


                                   </div>

                                   <div class="mb-3">
                                       <label class="form-label" for="meta_keywords">Meta Keywords *</label>
                                       <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter Meta Keywords" value="{{old('meta_keywords',$category?->meta_keywords ?? " ")}}">


                                   </div>

                                   <div class="mb-3">
                                       <label  for="menu_status">Show on Header Menu</label><br>
                                       <input type="checkbox"    name="menu_status" value="1" {{!empty($category?->menu_status) ? 'checked' :""}}>


                                   </div>



                               </div>
                               <div class="card-footer">
                                   <button type="submit" class="btn btn-primary">Submit</button>
                               </div>
                           </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>
@endsection

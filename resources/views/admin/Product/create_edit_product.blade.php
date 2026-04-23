@extends('admin.layout.layout')
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Catalogue Management</h3></div>
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












                            <form name="productForm" id="productForm" action="{{isset($product) ? route('products.update',$product->id):route('products.store')}}" method="post" enctype="multipart/form-data">@csrf
                                @if(isset($product)) @method("PUT") @endif
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="category_id" >Category Level(Select Category)*</label>
                                        <select name="category_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach($getCategories as $categ)
                                                <option value="{{$categ['id']}}" @if(old('category_id',$product->category_id ?? "") ==$categ['id']) selected @endif>{{$categ['name']}}</option>

                                                @if(!empty($categ['subcategories']))
                                                    @foreach($categ['subcategories'] as $subcat)
                                                        <option value="{{$subcat['id']}}" @if(old('category_id',$product->category_id ?? "") == $subcat['id']) selected  @endif>&nbsp;
                                                            &nbsp;&nbsp;&nbsp;&raquo;&raquo;{{$subcat['name']}}
                                                        </option>
                                                        @if(!empty($subcat['subcategories']))
                                                            @foreach($subcat['subcategories'] as $subcate)
                                                                <option value="{{$subcate['id']}}" @if(old('category_id',$product->category_id ?? "") == $subcate['id'] )selected @endif>&nbsp;
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&raquo;{{$subcate['name']}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="product_name">Product Name⁕</label>
                                        <input type="text" class="form-control " id="product_name" name="product_name" value="{{old('product_name',$product->product_name ?? "")}}" placeholder="Enter Product Name">

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="product_code">Product Code⁕</label>
                                        <input type="text" class="form-control " id="product_code" name="product_code" value="{{old('product_code',$product->product_code ?? "")}}" placeholder="Enter Product Code">

                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="product_color">Product Color⁕</label>
                                        <input type="text" class="form-control " id="product_color" name="product_color" value="{{old('product_color',$product->product_color ?? "")}}" placeholder="Enter Product Color">

                                    </div>


                                   <?php $familyColors = \App\Models\Color::colors();?>
                                    <div class="mb-3">
                                        <label class="form-label" for="family_color">Family Color</label>
                                        <select name="family_color" class="form-control">
                                            <option value="">Please Select</option>
                                            @foreach($familyColors as $color)
                                                <option value="{{$color->name}}" @if(isset($product['family_color']) && $product['family_color'] ==$color->name)selected @endif>{{$color->name}}</option>

                                            @endforeach
                                        </select>
                                    </div>




                                    <div class="mb-3">
                                        <label class="form-label" for="group_code">Group Code⁕</label>
                                        <input type="text" class="form-control " name="group_code" value="{{old('group_code',$product->group_code ?? "")}}" placeholder="Enter Group Code">

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="product_price">Product Price⁕</label>
                                        <input type="text" class="form-control " id="product_price" name="product_price" value="{{old('product_price',$product->product_price ?? "")}}" placeholder="Enter Product Price">

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="product_discount">Product Discount(%)</label>
                                        <input type="number" class="form-control "  step="0.01" name="product_discount" value="{{old('product_discount',$product->product_discount ?? "")}}" >

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="product_gst">Product GST(%)</label>
                                        <input type="number" class="form-control " step="0.01"   name="product_gst" value="{{old('product_gst',$product->product_gst ?? "")}}" >

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="product_weight">Product Weight (Grams)</label>
                                        <input type="number" step="0.01" class="form-control "    name="product_weight" value="{{old('product_weight',$product->product_weight ?? "")}}" >

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label " for="mainImageDropzone">Product Main Image(Max 1.00 Mb)</label>
                                        <div class="dropzone" id="mainImageDropzone"></div>
                                        <input type="hidden" name="main_image" id="main_image_hidden" value="{{ old('main_image', $product->main_image ?? '') }}">

                                        @if(!empty($product['main_image']))
                                            <a target="_blank" href="{{url('front/images/products/'.$product['main_image'])}}">
                                                <img style="width: 50px;margin: 10px" src="{{asset('front/images/products/'.$product['main_image'])}}"/>
                                            </a>
                                            <a style="color: #3f6ed3;" class="confirmDelete" title="Delete Product Image"
                                               href="javascript:void(0)" data-module="product-main-image" data-id="{{$product['id']}}">
                                                <i class="fas fa-trash"></i></a>
                                        @endif


                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label " for="productVideoDropzone">Product Video (Max 10.00 Mb)</label>
                                        <div class="dropzone" id="productVideoDropzone"></div>
                                        <input type="hidden" name="product_video" id="product_video_hidden" value="{{ old('product_video', $product->product_video ?? '') }}">

                                        @if(!empty($product['product_video']))
                                            <a target="_blank" href="{{url('front/videos/products/'.$product['product_video'])}}">View Video</a>

                                            <a  class="confirmDelete" title="Delete Product Image"
                                               href="javascript:void(0)" data-module="product-video" data-id="{{$product['id']}}">Delete Video
                                               </a>
                                        @endif


                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="wash_care">Wash Care</label>
                                        <textarea name="wash_care"  class="form-control" placeholder="Enter Wash Care" > {{old('wash_care',$product->wash_care ?? "")}}</textarea>
                                    </div>



                                    <div class="mb-3">
                                        <label class="form-label" for="description">Product Description </label>
                                        <textarea name="description"  id="description" class="form-control" placeholder="Enter Product Description" rows="3"> {{old('description',$product->description ?? "")}}</textarea>
                                    </div>



                                    <div class="mb-3">
                                        <label class="form-label" for="search_keywords">Search Keywords  </label>
                                        <textarea name="search_keywords"   class="form-control" placeholder="Enter Search Keywords"  > {{old('search_keywords',$product->search_keywords ?? "")}}</textarea>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="meta_title">Meta Title  </label>
                                        <input type="text" name="meta_title" class="form-control" value="{{old('meta_title',$product->meta_title ?? "")}}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="meta_description">Meta Description </label>
                                        <input name="meta_description"  type="text" class="form-control"   value=" {{old('meta_description',$product->meta_description ?? "")}}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="meta_keywords">Meta Keywords </label>
                                        <input name="meta_keywords"  type="text" class="form-control"   value=" {{old('meta_keywords',$product->meta_keywords ?? "")}}">
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="is_featured">Is Featured? </label>
                                        <select name="is_featured" class="form-select">
                                            <option value="no" {{(old('is_featured',$product->is_featured ?? "") == 'no' ? 'selected' : "")}}>
                                                No
                                            </option>

                                            <option value="yes" {{(old('is_featured',$product->is_featured ?? "") == 'yes' ? 'selected' : "")}}>
                                                Yes
                                            </option>
                                        </select>


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

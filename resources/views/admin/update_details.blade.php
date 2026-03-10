@extends('admin.layout.layout')
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Admin Management</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Password</li>
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
                                    Update Password
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












                            <form method="post" action="{{route('admin.update_details.request')}}" enctype="multipart/form-data">@csrf
                                {{--   begin-Body--}}
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="email" value="{{Auth::guard('admin')->user()->email}}" readonly style="background-color: #ccc">

                                    </div>


                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name"  name="name" value="{{Auth::guard('admin')->user()->name}}" >

                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{Auth::guard('admin')->user()->phone}}">

                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">image</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        @if(!empty(Auth::guard('admin')->user()->image))
                                            <div id="profileimageBlock">
                                                <a target="_blank" href="{{url('admin/images/photo/'.Auth::guard('admin')->user()->image}}">View</a>|
                                                <input type="hidden" name="current_image" value="{{Auth::guard('admin')->user()->image}}">
                                                <a target="javascript:void(0)" id="deleteProfileImage" data-admin-id="Auth::guard('admin')->user()->image}" class="text-danger" >Delete</a>

                                            </div>

                                        @endif
                                    </div>
                                </div>

                                {{--   end:Body--}}
                                {{--  Start:Footer--}}
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

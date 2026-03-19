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


                            <form name="subadminForm" id="subadminForm" action="{{url('admin/add-edit-subadmin/request')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($subadmindata['id']))
                                    <input type="hidden" name="id" value="{{$subadmindata['id']}}">
                                @endif
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" @if(!empty($subadmindata['email']))
                                           value="{{$subadmindata['email']}}" readonly style="background-color: #ccc";
                                        @endif>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your name"
                                        @if(!empty($subadmindata['name'])) value="{{$subadmindata['name']}}" @endif
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label for="Phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Your Phone number"
                                               @if(!empty($subadmindata['phone'])) value="{{$subadmindata['phone']}}" @endif
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image" placeholder="Please Upload Your Image" accept="image/*"
                                        >
                                        @if(!empty($subadmindata['image']))
                                            <a href="{{asset('admin/images/photos/'.$subadmindata['image'])}}">View Photo</a>
                                            <input type="hidden" name="current_image" value="{{$subadmindata['image']}}">
                                        @endif

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>
@endsection

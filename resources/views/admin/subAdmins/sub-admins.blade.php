@extends('admin.layout.layout')
@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Admin Management</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a> </li>
                            <li class="breadcrumb-item active" aria-current="page"> SubAdmins </li>


                        </ol>
                    </div>
                </div>
            </div>
        </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h2 class="card-title">SubAdmins</h2>
                                <a style="max-width: 150px; float:right; display: inline-block;" href="{{url('admin/add-edit-subadmin')}}" class="btn btn-block btn-primary">Add Sub Admin</a>

                            </div>
                            <div class="card-body">
                                @if(Session::has('success_message'))
                                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                        <strong>Success: </strong>{{Session::get('success_message')}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <table id="subadmins" class="table table-bordered table-striped">

                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Actions</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subadmins as $subadmin)
                                        <tr>
                                            <td>{{$subadmin->id}}</td>
                                            <td>
                                                @if(!empty($subadmin->image))
                                                    <img src="{{asset('admin/images/photos/'.$subadmin->image)}}" alt="Subadmin photo" width="40" height="40" style="object-fit: contain; background: #f1f3f5; border-radius: 4px;">
                                                @else
                                                    <div style="width:40px;height:40px;background:#e9ecef;border-radius:4px;"></div>
                                                @endif
                                            </td>
                                            <td>{{$subadmin->name}}</td>
                                            <td>{{$subadmin->phone}}</td>
                                            <td>{{$subadmin->email}}</td>
                                            <td>

                                                @if($subadmin->status == 1)
                                                    <a class="updateSubadminStatus text-decoration-none" data-subadmin_id="{{$subadmin->id}}" style="color: #3f6ed3" href="javascript:void(0)">
                                                       <i class="fas fa-toggle-on" data-status="Active"></i>
                                                    </a>
                                                @else
                                                    <a class="updateSubadminStatus text-decoration-none" data-subadmin_id="{{$subadmin->id}}" style="color: gray" href="javascript:void(0)">
                                                        <i class="fas fa-toggle-off" data-status="Inactive"></i>
                                                    </a>
                                                @endif &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a class="text-decoration-none" href="{{url('admin/add-edit-subadmin/'.$subadmin->id)}}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                    <a title="Set Permisssions for Sub-admin" href="{{url('admin/update-role/'.$subadmin->id)}}"><i class="fas fa-unlock"></i></a>&nbsp;
                                                &nbsp;&nbsp;<a class="text-decoration-none" style='color: #3f6ed3;' title="Delete Subadmin" href="{{url('admin/delete-subadmin/'.$subadmin->id)}}"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </main>
@endsection

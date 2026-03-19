@extends('admin.layout.layout')
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Admin Management</h3>
                    </div>
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
                    <div class="col-md-8">
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
                            <form action="{{ route('admin.update_role.request') }}" method="post" name="subadminForm">
                                @csrf
                                <input type="hidden" name="subAdminId" value="{{$id}}">
                                @php
                                    $roleMap = [];
                                    if (!empty($subadminRoles)) {
                                    foreach ($subadminRoles as $role) {
                                    $roleMap[$role['module']] = $role;
                                    }
                                    }
                                @endphp
                                <div class="card-body">
                                    <div class="form-group col-md-12">
                                        @foreach($modules as $module)
                                            @php
                                                $moduleRole = $roleMap[$module] ?? [];
                                                $viewChecked = !empty($moduleRole['view_access']) ? 'checked' : '';
                                                $editChecked = !empty($moduleRole['edit_access']) ? 'checked' : '';
                                                $fullChecked = !empty($moduleRole['full_access']) ? 'checked' : '';
                                            @endphp
                                            <div class="row align-items-center border-bottom pb-2 mb-2">
                                                <input type="hidden" name="roles[{{$module}}][module]" value="{{$module}}">
                                                <div class="col-md-3 fw-semibold mb-2 mb-md-0">{{ ucfirst($module) }}:</div>
                                                <div class="col-md-9 d-flex flex-wrap justify-content-center gap-3">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input me-1 perm-view" data-module="{{$module}}" type="checkbox" name="roles[{{$module}}][view]" value="1" {{$viewChecked}}>
                                                        View Access
                                                    </label>
                                                    <label class="form-check-label">
                                                        <input class="form-check-input me-1 perm-edit" data-module="{{$module}}" type="checkbox" name="roles[{{$module}}][edit]" value="1" {{$editChecked}}>
                                                        View/Edit Access
                                                    </label>
                                                    <label class="form-check-label">
                                                        <input class="form-check-input me-1 perm-full" data-module="{{$module}}" type="checkbox" name="roles[{{$module}}][full]" value="1" {{$fullChecked}}>
                                                        Full Access
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function syncModule(module) {
                const full = document.querySelector('.perm-full[data-module="' + module + '"]');
                const view = document.querySelector('.perm-view[data-module="' + module + '"]');
                const edit = document.querySelector('.perm-edit[data-module="' + module + '"]');
                if (!full || !view || !edit) return;

                if (full.checked) {
                    view.checked = false;
                    edit.checked = false;
                    view.disabled = true;
                    edit.disabled = true;
                } else {
                    view.disabled = false;
                    edit.disabled = false;
                }
            }

            document.querySelectorAll('.perm-full').forEach(function (el) {
                el.addEventListener('change', function () {
                    syncModule(el.dataset.module);
                });
            });

            document.querySelectorAll('.perm-view, .perm-edit').forEach(function (el) {
                el.addEventListener('change', function () {
                    const module = el.dataset.module;
                    const full = document.querySelector('.perm-full[data-module="' + module + '"]');
                    if (full && el.checked) {
                        full.checked = false;
                    }
                    syncModule(module);
                });
            });

            document.querySelectorAll('.perm-full').forEach(function (el) {
                syncModule(el.dataset.module);
            });
        });
    </script>
@endsection

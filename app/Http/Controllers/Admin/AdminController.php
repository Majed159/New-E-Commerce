<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\PasswordRequest;
use App\Http\Requests\Admin\SubadminRequest;
use App\Http\Services\Admin\AdminService;
use App\http\Requests\Admin\DetailRequest;
use App\Models\Admin;
use App\Models\AdminsRole;
use Session;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $adminService;
    // Inject AdminService
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }


    public function index()
    {
        Session::put('page','dashboard');

        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoginRequest $request)
    {
//        $data = $request->all();
//        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
//            return redirect('admin/dashboard');
//        } else {
//
//        return redirect('admin/login')->back()->with('error', 'Invalid Email or Password');
//    }
        $data = $request->all();

        $loginStatus =$this->adminService->login($data);
        if ($loginStatus == "success") {
            return redirect()->route('dashboard.index');

        }elseif ($loginStatus == "inactive") {
            return redirect('admin/login')->with('error_message', 'Your account is not activated, please contact your administrator');

        }else{
            return redirect()->route('admin.login')->with('error_message', 'Wrong Email or password');
        }
}

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        Session::put('page','update-password');
        return view('admin.update_password', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function verifyPassword(Request $request)
    {
        $data = $request->all();
        $isValid = $this->adminService->verifyPassword($data);
        return response()->json($isValid);
    }
    public function updatePasswordRequest (PasswordRequest $request)
    {
        if ($request->isMethod('post')) {
            $pwdStatus = $this->adminService->updatePassword($request->all());
            if ($pwdStatus['status'] == "success") {
                return redirect()->back()->with('success_message', $pwdStatus['message']);
            } else {
                return redirect()->back()->with('error_message', $pwdStatus['message']);
            }
        }
    }

    public  function editDetails()
    {
        Session::put('page','update_details');
        return view('admin.update_details');
    }

    public function updateDetails(DetailRequest $request)
    {
        \Illuminate\Support\Facades\Session::put('page', 'update_details');
        if ($request->isMethod('post')) {
            $this->adminService->updateDetails($request);
            return redirect()->route('admin.update_details')->with('success_message', 'Admin Details has been updated successfully!');
        }

    }
    public  function  deleteProfileImage(Request $request){


    $status = $this->adminService->deleteProfileImage($request->admin_id);
    return response()->json($status);

    }
public  function subAdmins()
{
    Session::put('page','sub-admins');
    $subadmins = $this->adminService->subAdmins();
    return view('admin.subAdmins.sub-admins', compact('subadmins'));
}

public  function updateSubAdminsStatus(Request $request)
{
//    if ($request->ajax(){
//    $data = $request->all();
//    $status = $this->adminService->updateSubAdminsStatus($data);
//    return response()->json(['status'=>$status,'subadmin_id'=>$data['subadmin_id']]);
//
//    }

    if ($request->ajax())
    {
        $data = $request->all();
        $status = $this->adminService->updateSubAdminsStatus($data);
          return response()->json(['status'=>$status,'subadmin_id'=>$data['subadmin_id']]);

    }


}


    public  function deleteSubAdmin( $id)
    {
    $result =$this->adminService->deleteSubAdmin($id);
    return redirect()->route('admin.subAdmins')->with('success_message', $result['message']);
    }
    public  function editSubAdmin($id =null)
    {
    if ($id == ""){
        $title = "Add New SubAdmin";
        $subadmindata = array();
    }else{
        $title = "Edit SubAdmin";
        $subadmindata = Admin::find($id);
    }
    return view('admin.subAdmins.edit_subadmin', compact('title','subadmindata'));
    }


    public  function  addEditSubAdminRequest(SubadminRequest $request)
    {
        if ($request->isMethod('post')) {
            $result = $this->adminService->addEditSubadmin($request);
            return redirect('admin/subAdmins')->with('success_message', $result['message']);
        }
    }

    public function UpdateRole($id)
    {
            $subadminRoles = AdminsRole::where('subAdminId',$id)->get()->toArray();
            $subadminDetails = Admin::where('id',$id)->first()->toArray();
            $modules=['categories','products','orders','users','subscribers'];
            $title = "Update ".$subadminDetails['name']." Subadmin Roles/Permissions";
            return view('admin.subAdmins.update_roles', compact('title','id','subadminRoles','modules'));
    }

    public  function UpdateRoleRequest(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $service = new AdminService();
            $request=$service->updateRole($request);
        }
        return redirect('admin/subAdmins')->with('success_message', $request['message']);

    }
}

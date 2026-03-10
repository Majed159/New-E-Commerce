<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\PasswordRequest;
use App\Http\Services\Admin\AdminService;
use App\http\Requests\Admin\DetailRequest;
use App\Models\Admin;
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
        if ($loginStatus == 1) {
            return redirect()->route('dashboard.index');

        }else{
            return redirect('admin/login')->with('error_message', 'Invalid Email or Password');

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

    public function updateDetails(DetailRequest $request): ?\Illuminate\Http\RedirectResponse
    {
        \Illuminate\Support\Facades\Session::put('page', 'update_details');
        if ($request->isMethod('post')) {
            $this->adminService->updateDetails($request);
            return redirect()->route('admin.update_details')->with('success_message', 'Admin Details has been updated successfully!');
        }

    }


}

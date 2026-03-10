<?php
namespace  App\Http\Services\Admin;
use App\Http\Requests\Admin\DetailRequest;
use App\Models\Admin;
use Auth,Hash;
use Illuminate\Support\Facades\Session;


class AdminService
{
    public function login($data)
    {
        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
          //remember Admin and email
            if (!empty($data['remember'])) {
                setcookie('email', $data['email'], time() + 3600 * 24 );
                setcookie('password', $data['password'], time() + 3600 * 24 );
            }else{
                setcookie("email",'');
                setcookie("password",'');
            }
            $loginStatus = 1;
        }else{
            $loginStatus = 0;
        }
        return $loginStatus;
    }
    public function verifyPassword($data){
        $currentPwd = $data['current_pwd'] ?? null;
        $admin = Auth::guard('admin')->user();

        if (!$currentPwd || !$admin) {
            return false;
        }

        return Hash::check($currentPwd, $admin->password);
    }

    public function updatePassword($data)
    {
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {

            if ($data['new_pwd'] == $data['confirm_pwd']) {
                Admin::where('email', Auth::guard('admin')->user()->email)->update(['password' => Hash::make($data['new_pwd'])]);
                $status = "success";
                $message = "Password has been updated successfully!";
            }else
            {
                $status = "error";
                $message = "New password and confirm password not matched!";
            }
        }else
        {
            $status = "error";
            $message = "Current password not matched!";
        }
        return ['status' => $status, 'message' => $message];
    }

   public  function  updateDetails($request)
   {
       $data = $request->all();
       Admin::where('email', Auth::guard('admin')->user()->email)->update([
           'name' => $data['name'],
           'phone' => $data['phone'],
           ]);
   }

}


<?php
namespace  App\Http\Services\Admin;
use App\Http\Requests\Admin\DetailRequest;
use App\Models\Admin;
use App\Models\User;
use Auth,Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;
use Random\RandomException;

class AdminService
{
    public function login($data)
    {
//        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
//            //remember Admin and email
//            if (!empty($data['remember'])) {
//                setcookie('email', $data['email'], time() + 3600 * 24);
//                setcookie('password', $data['password'], time() + 3600 * 24);
//            } else {
//                setcookie("email", '');
//                setcookie("password", '');
//            }
//            $loginStatus = 1;
//        } else {
//            $loginStatus = 0;
//        }
//        return $loginStatus;
        $admin = Admin::where('email',$data['email'])->first();
        if($admin){
            if ($admin->status == 0){
                return "inactive";

                 }
            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'] ,'status' => 1])) {
                if (!empty($data['remember'])) {
                    setcookie('email', $data['email'], time() + 3600 * 24);
                    setcookie('password', $data['password'], time() + 3600 * 24);
                } else {
                    setcookie("email", '');
                    setcookie("password", '');
                }
                return "success";
            } else{
                return "invalid";
            }
        }else{
            return "invalid";
        }
    }

    public function verifyPassword($data)
    {
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
            } else {
                $status = "error";
                $message = "New password and confirm password not matched!";
            }
        } else {
            $status = "error";
            $message = "Current password not matched!";
        }
        return ['status' => $status, 'message' => $message];
    }

    public function updateDetails($request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $image_temp = $request->file('image');
            if ($image_temp->isValid()) {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($image_temp);
                $extension = $image_temp->getClientOriginalExtension();
                $imageName = rand(11111, 99999) . '.' . $extension;
                $imageDir = public_path('admin/images/photos');
                if (!is_dir($imageDir)) {
                    if (!mkdir($imageDir, 0755, true) && !is_dir($imageDir)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $imageDir));
                    }
                }
                $imagePath = $imageDir . DIRECTORY_SEPARATOR . $imageName;
                $image->save($imagePath);
            }
        } elseif (!empty($data['current_image'])) {
            $imageName = $data['current_image'];
        } else {
            $imageName = "";
        }
        Admin::where('email', Auth::guard('admin')->user()->email)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'image' => $imageName,
        ]);
    }

    public function deleteProfileImage($adminId)
    {
        $adminId = (int)$adminId;
        if ($adminId <= 0) {
            return ['status' => false, 'message' => 'Invalid admin id.'];
        }

        $profileImage = Admin::where('id', $adminId)->value('image');
        if ($profileImage) {
            $profileImagePath = public_path('admin/images/photos/' . $profileImage);
            if (file_exists($profileImagePath)) {
                unlink($profileImagePath);
            }
            Admin::where('id', $adminId)->update(['image' => null]);
            return ['status' => true, 'message' => 'Profile Image deleted successfully!'];
        }
        return ['status' => false, 'message' => 'Image not found!'];
    }

    public function subAdmins()
    {
        $subadmins = Admin::whereIn('role', ['Sub_Admin'])->get();
        return $subadmins;
    }

    public function updateSubAdminsStatus($data)
    {
     $status = ($data['status'] == "Active") ? 0 : 1;
     Admin::where('id', $data['subadmin_id'])->update(['status' => $status]);
     return $status;
    }

    public function deleteSubAdmin($id)
    {
        Admin::where('id', $id)->delete();
        $message = "SubAdmin deleted successfully!";
        return array("message" => $message);
    }


    /**
     * @throws RandomException
     */
    public function addEditSubadmin($request)
    {
    $data = $request->all();
    $isNew = empty($data['id']);
    if (!$isNew){
        $subadmindata = Admin::find($data['id']);
        $message = "SubAdmin updated successfully!";

    }else
    {
        $subadmindata = new Admin();
        $message = "SubAdmin added successfully!";
    }
    if ($request->hasFile('image')) {
        $image_temp = $request->file('image');
        if ($image_temp->isValid()) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($image_temp);
            $extension = $image_temp->getClientOriginalExtension();
            $imageName = random_int(11111, 99999) . '.' . $extension;
            $imageDir = public_path('admin/images/photos');
            if (!is_dir($imageDir)) {
                if (!mkdir($imageDir, 0755, true) && !is_dir($imageDir)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $imageDir));
                }
            }
            $imagePath = $imageDir . DIRECTORY_SEPARATOR . $imageName;
            $image->save($imagePath);

        }
    }elseif (!empty($data['current_image'])) {
        $imageName = $data['current_image'];
    }else
    {
        $imageName = "";
    }
        $subadmindata->image = $imageName;
        $subadmindata->name = $data['name'];
        $subadmindata->phone = $data['phone'];
        $subadmindata->email = $data['email'];

        if ($isNew){
            $subadmindata->role = 'Sub_Admin';
            $subadmindata->status = 1;
        }
        if ($data['password'] != "") {
            $subadmindata->password = Hash::make($data['password']);
        }
        $subadmindata->save();
        return ['message' => $message];
    }
    }



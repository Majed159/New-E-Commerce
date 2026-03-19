<?php

namespace Database\Seeders;

use App\Models\Admin;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('12345678');
        $admin = new Admin;
        $admin->name = 'Admin';
        $admin->role = 'admin';
        $admin->phone = '0123456789';
        $admin->email ='admin@admin.com';

        $admin->password = $password;
        $admin->status = 1;
        $admin->save();
         $admin = new Admin();
         $admin->name = 'Sub Admin';
        $admin->role = 'Sub_Admin';
        $admin->phone = '0123456789';
        $admin->email ='SubAdmin@admin.com';
        $admin->password = $password;
        $admin->status = 1;
        $admin->save();

        $admin = new Admin();
        $admin->name = 'Sub Admin 2';
        $admin->role = 'Sub_Admin';
        $admin->phone = '0123456789';
        $admin->email ='SubAdmin2@admin.com';
        $admin->password = $password;
        $admin->status = 1;
        $admin->save();
    }
}

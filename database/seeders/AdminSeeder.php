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
        $admin->status =1;
        $admin->save();
    }
}

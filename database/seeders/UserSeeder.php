<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $super_admin_user = User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@themesdesign.com',
        //     'password' => Hash::make('123456'),
        //     'avatar' =>"123",
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        //     'utype' =>1
        // ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'name' => '超级管理员',
        ]);
    }
}

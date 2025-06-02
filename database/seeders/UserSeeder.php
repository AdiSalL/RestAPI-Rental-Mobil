<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table("users")->insert([
            "name" => "Admin",
            "email" => "admin@admin.com",
            "phone_number" => "081225200260",
            "role" => "admin",
            "password" => bcrypt("password123"),
            "created_at" => now(),
            "updated_at" => now()
        ]);
    }
}

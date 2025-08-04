<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Nova',
                'email' => 'admin@novasmart.vn',
                'role_id' => 1, // <- role admin
                'password' => bcrypt('admin1234'), // hoặc mật khẩu mạnh hơn
            ],
            [
                'name' => 'John Michael',
                'email' => 'john@creative-tim.com',
                'role_id' => 2,
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Alexa Liras',
                'email' => 'alexa@creative-tim.com',
                'role_id' => 2,
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Laurent Perrier',
                'email' => 'laurent@creative-tim.com',
                'role_id' => 2,
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Michael Levi',
                'email' => 'michael@creative-tim.com',
                'role_id' => 2,
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Richard Gran',
                'email' => 'richard@creative-tim.com',
                'role_id' => 2,
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Miriam Eric',
                'email' => 'miriam@creative-tim.com',
                'role_id' => 2,
                'password' => bcrypt('password'),
            ],
        ]);
    }
}

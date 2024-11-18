<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 10 người dùng ngẫu nhiên
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Tạo 10 người dùng ngẫu nhiên với vai trò user
        User::factory()->count(10)->create([
            'role_id' => $userRole->id, // Gán role_id là user
        ]);

        // Tạo một Admin mẫu
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role_id' => $adminRole->id, // Gán role_id là admin
        ]);
    }
}

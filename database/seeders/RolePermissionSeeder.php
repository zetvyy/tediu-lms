<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner'
        ]);

        $studentRole = Role::create([
            'name' => 'student'
        ]);

        $teacherRole = Role::create([
            'name' => 'teacher'
        ]);

        $userOwner = User::create([
            'name' => 'Teman Digital UMKM',
            'email' => 'tediu.id@gmail.com',
            'password' => bcrypt('tediu123@'),
            'occupation' => 'Super Admin',
            'avatar' => 'image/default-avatar.png',
        ]);

        $userOwner->assignRole($ownerRole);
    }
}

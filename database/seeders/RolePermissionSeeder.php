<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'manage countries',
            'manage cities',
            'manage hotel bookings',
            'checkout hotels',
            'view hotel bookings',
        ];

        foreach($permissions as $permissi){
            Permission::firstOrCreate([
                'name' => $permissi
            ]);
        }

        $customerRole = Role::firstOrCreate([
            'name' => 'customer',
        ]);

        $customerPermissions = [
            'checkout hotels',
            'view hotel bookings',
        ];

        $customerRole->syncPermissions($customerPermissions);

        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
        ]);

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'avatar' => 'images/dummyavatar.png',
            'phone' => '081234567',
            'password' => bcrypt('admin123'),
        ]);

        $user->assignRole($superAdminRole);
    }
}

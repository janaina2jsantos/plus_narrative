<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('roles')->get()->count() == 0) {
            $roles = [
                'admin' => ['view admin dashboard', 'administer users'],
                'content manager' => ['view admin dashboard'],
                'user' => []
            ];

            $permissions = array_unique(array_merge(...array_values($roles)));

            // creating permissions
            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName]);
            }

            // creating roles and assigning permissions
            foreach ($roles as $roleName => $rolePermissions) {
                $role = Role::firstOrCreate(['name' => $roleName]);
                $permissionIds = Permission::whereIn('name', $rolePermissions)->pluck('id')->toArray();
                $role->syncPermissions($permissionIds);
            }
        } 
        else { 
            echo "Unable to run the seed. The table is not empty.";
            die(); 
        }
    }
}

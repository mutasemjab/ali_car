<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $modules = [
            'role',
            'employee',
            'customer',
            'category',
            'invoice',
            'purchaseOrder',
            'warehouse',
            'product',
            'unit',
            'report',
            'home',
        ];

         // Create all permissions
         foreach ($modules as $module) {
            $actions = ['table', 'add', 'edit', 'delete'];
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "$module-$action",
                    'guard_name' => 'admin',
                ]);
            }
        }

        // Create "customer" role if it does not exist
        $customerRole = Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => 'admin',
        ]);

        // Assign only specific permissions to "customer"
        $customerPermissions = [
            'purchaseOrder-table',
            'purchaseOrder-add',
            'purchaseOrder-edit',
            'purchaseOrder-delete',
            'invoice-table',
            'invoice-add',
            'invoice-edit',
            'invoice-delete',
            'home-table',
        ];

        $customerRole->syncPermissions($customerPermissions);
    }
}

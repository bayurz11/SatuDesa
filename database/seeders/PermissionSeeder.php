<?php

namespace Database\Seeders;

use App\Domains\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Post permissions
            ['name' => 'posts.view', 'display_name' => 'View Posts', 'description' => 'Can view post list and details', 'group' => 'posts'],
            ['name' => 'posts.create', 'display_name' => 'Create Posts', 'description' => 'Can create new posts', 'group' => 'posts'],
            ['name' => 'posts.edit', 'display_name' => 'Edit Posts', 'description' => 'Can edit existing posts', 'group' => 'posts'],
            ['name' => 'posts.delete', 'display_name' => 'Delete Posts', 'description' => 'Can delete posts', 'group' => 'posts'],
            ['name' => 'posts.publish', 'display_name' => 'Publish Posts', 'description' => 'Can publish and unpublish posts', 'group' => 'posts'],
            ['name' => 'post_categories.view', 'display_name' => 'View Post Categories', 'description' => 'Can view post category list', 'group' => 'posts'],
            ['name' => 'post_categories.create', 'display_name' => 'Create Post Categories', 'description' => 'Can create new post categories', 'group' => 'posts'],
            ['name' => 'post_categories.edit', 'display_name' => 'Edit Post Categories', 'description' => 'Can edit post categories', 'group' => 'posts'],
            ['name' => 'post_categories.delete', 'display_name' => 'Delete Post Categories', 'description' => 'Can delete post categories', 'group' => 'posts'],
            ['name' => 'announcements.view', 'display_name' => 'View Announcements', 'description' => 'Can view announcement list and details', 'group' => 'announcements'],
            ['name' => 'announcements.create', 'display_name' => 'Create Announcements', 'description' => 'Can create new announcements', 'group' => 'announcements'],
            ['name' => 'announcements.edit', 'display_name' => 'Edit Announcements', 'description' => 'Can edit existing announcements', 'group' => 'announcements'],
            ['name' => 'announcements.delete', 'display_name' => 'Delete Announcements', 'description' => 'Can delete announcements', 'group' => 'announcements'],
            ['name' => 'announcements.publish', 'display_name' => 'Publish Announcements', 'description' => 'Can publish and unpublish announcements', 'group' => 'announcements'],

            // User permissions
            ['name' => 'users.view', 'display_name' => 'View Users', 'description' => 'Can view user list and details', 'group' => 'users'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'description' => 'Can create new users', 'group' => 'users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'description' => 'Can edit existing users', 'group' => 'users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'description' => 'Can delete users', 'group' => 'users'],

            // Citizen permissions
            ['name' => 'citizens.view', 'display_name' => 'View Citizens', 'description' => 'Can view citizen list and details', 'group' => 'citizens'],
            ['name' => 'citizens.create', 'display_name' => 'Create Citizens', 'description' => 'Can create citizen records', 'group' => 'citizens'],
            ['name' => 'citizens.edit', 'display_name' => 'Edit Citizens', 'description' => 'Can edit citizen records', 'group' => 'citizens'],
            ['name' => 'citizens.delete', 'display_name' => 'Delete Citizens', 'description' => 'Can delete citizen records', 'group' => 'citizens'],
            ['name' => 'citizen_births.view', 'display_name' => 'View Citizen Births', 'description' => 'Can view citizen birth records', 'group' => 'citizens'],
            ['name' => 'citizen_births.create', 'display_name' => 'Create Citizen Births', 'description' => 'Can create citizen birth records', 'group' => 'citizens'],
            ['name' => 'citizen_births.edit', 'display_name' => 'Edit Citizen Births', 'description' => 'Can edit citizen birth records', 'group' => 'citizens'],
            ['name' => 'citizen_births.delete', 'display_name' => 'Delete Citizen Births', 'description' => 'Can delete citizen birth records', 'group' => 'citizens'],
            ['name' => 'citizen_arrivals.view', 'display_name' => 'View Citizen Arrivals', 'description' => 'Can view citizen arrival records', 'group' => 'citizens'],
            ['name' => 'citizen_arrivals.create', 'display_name' => 'Create Citizen Arrivals', 'description' => 'Can create citizen arrival records', 'group' => 'citizens'],
            ['name' => 'citizen_arrivals.edit', 'display_name' => 'Edit Citizen Arrivals', 'description' => 'Can edit citizen arrival records', 'group' => 'citizens'],
            ['name' => 'citizen_arrivals.delete', 'display_name' => 'Delete Citizen Arrivals', 'description' => 'Can delete citizen arrival records', 'group' => 'citizens'],
            ['name' => 'citizen_deaths.view', 'display_name' => 'View Citizen Deaths', 'description' => 'Can view citizen death records', 'group' => 'citizens'],
            ['name' => 'citizen_deaths.create', 'display_name' => 'Create Citizen Deaths', 'description' => 'Can create citizen death records', 'group' => 'citizens'],
            ['name' => 'citizen_deaths.edit', 'display_name' => 'Edit Citizen Deaths', 'description' => 'Can edit citizen death records', 'group' => 'citizens'],
            ['name' => 'citizen_deaths.delete', 'display_name' => 'Delete Citizen Deaths', 'description' => 'Can delete citizen death records', 'group' => 'citizens'],
            ['name' => 'households.view', 'display_name' => 'View Households', 'description' => 'Can view household records', 'group' => 'citizens'],
            ['name' => 'households.create', 'display_name' => 'Create Households', 'description' => 'Can create household records', 'group' => 'citizens'],
            ['name' => 'households.edit', 'display_name' => 'Edit Households', 'description' => 'Can edit household records', 'group' => 'citizens'],
            ['name' => 'households.delete', 'display_name' => 'Delete Households', 'description' => 'Can delete household records', 'group' => 'citizens'],
            ['name' => 'hamlets.view', 'display_name' => 'View Hamlets', 'description' => 'Can view hamlet records', 'group' => 'citizens'],
            ['name' => 'hamlets.create', 'display_name' => 'Create Hamlets', 'description' => 'Can create hamlet records', 'group' => 'citizens'],
            ['name' => 'hamlets.edit', 'display_name' => 'Edit Hamlets', 'description' => 'Can edit hamlet records', 'group' => 'citizens'],
            ['name' => 'hamlets.delete', 'display_name' => 'Delete Hamlets', 'description' => 'Can delete hamlet records', 'group' => 'citizens'],
            ['name' => 'rws.view', 'display_name' => 'View RWs', 'description' => 'Can view RW records', 'group' => 'citizens'],
            ['name' => 'rws.create', 'display_name' => 'Create RWs', 'description' => 'Can create RW records', 'group' => 'citizens'],
            ['name' => 'rws.edit', 'display_name' => 'Edit RWs', 'description' => 'Can edit RW records', 'group' => 'citizens'],
            ['name' => 'rws.delete', 'display_name' => 'Delete RWs', 'description' => 'Can delete RW records', 'group' => 'citizens'],
            ['name' => 'rts.view', 'display_name' => 'View RTs', 'description' => 'Can view RT records', 'group' => 'citizens'],
            ['name' => 'rts.create', 'display_name' => 'Create RTs', 'description' => 'Can create RT records', 'group' => 'citizens'],
            ['name' => 'rts.edit', 'display_name' => 'Edit RTs', 'description' => 'Can edit RT records', 'group' => 'citizens'],
            ['name' => 'rts.delete', 'display_name' => 'Delete RTs', 'description' => 'Can delete RT records', 'group' => 'citizens'],

            // APBDes permissions
            ['name' => 'budgets.view', 'display_name' => 'View APBDes', 'description' => 'Can view APBDes dashboard and summaries', 'group' => 'budgets'],
            ['name' => 'budgets.create', 'display_name' => 'Create APBDes Data', 'description' => 'Can create fiscal years, budget lines, and APBDes master data', 'group' => 'budgets'],
            ['name' => 'budgets.edit', 'display_name' => 'Edit APBDes Data', 'description' => 'Can edit APBDes master data and budget lines', 'group' => 'budgets'],
            ['name' => 'budgets.delete', 'display_name' => 'Delete APBDes Data', 'description' => 'Can delete APBDes data records', 'group' => 'budgets'],
            ['name' => 'budgets.approve', 'display_name' => 'Approve APBDes', 'description' => 'Can approve APBDes draft and publication stage', 'group' => 'budgets'],
            ['name' => 'budgets.report', 'display_name' => 'View APBDes Reports', 'description' => 'Can access APBDes reports and accountability summaries', 'group' => 'budgets'],
            
            // Role permissions
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'description' => 'Can view role list and details', 'group' => 'roles'],
            ['name' => 'roles.create', 'display_name' => 'Create Roles', 'description' => 'Can create new roles', 'group' => 'roles'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'description' => 'Can edit existing roles', 'group' => 'roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'description' => 'Can delete roles', 'group' => 'roles'],
            
            // Permission permissions
            ['name' => 'permissions.view', 'display_name' => 'View Permissions', 'description' => 'Can view permission list', 'group' => 'permissions'],
            ['name' => 'permissions.manage', 'display_name' => 'Manage Permissions', 'description' => 'Can assign/remove permissions from roles', 'group' => 'permissions'],
            
            // System permissions
            ['name' => 'system.settings', 'display_name' => 'System Settings', 'description' => 'Can access system settings', 'group' => 'system'],
            ['name' => 'system.logs', 'display_name' => 'View Logs', 'description' => 'Can view system logs', 'group' => 'system'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}

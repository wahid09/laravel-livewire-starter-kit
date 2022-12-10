<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $ModuleDashboard = Module::updateOrCreate([
        //     'name' => 'Admin Dashboard',
        //     'paraent_id' => 0,
        //     'sort_order' => 1,
        //     'slug' => 'dashboard',
        //     'url' => 'app.dashboard',
        //     'icon' => 'fas fa-th'
        // ]);

        // Permission::updateOrCreate([
        //     'module_id' => $ModuleDashboard->id,
        //     'name' => 'Access Dashboard',
        //     'slug' => 'access-dashboard'
        // ]);

        $ModuleDevConsole = Module::updateOrCreate([
            'name' => 'Dev Console',
            'parent_id' => 0,
            'sort_order' => 2,
            'slug' => 'dev-console',
            'url' => 'dev',
            'icon' => 'fas fa-th'
        ]);

        Permission::updateOrCreate([
            'module_id' => $ModuleDevConsole->id,
            'name' => 'Access Dev Console',
            'slug' => 'access-dev-console'
        ]);

        $moduleRole = Module::updateOrCreate([
            'name' => 'Roles',
            'parent_id' => $ModuleDevConsole->id,
            'sort_order' => 3,
            'slug' => 'role',
            'url' => 'dev/roles',
            'icon' => 'fas fa-columns'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleRole->id,
            'name' => 'Role Index',
            'slug' => 'role-index'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleRole->id,
            'name' => 'Role Create',
            'slug' => 'role-create'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleRole->id,
            'name' => 'Role Update',
            'slug' => 'role-update'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleRole->id,
            'name' => 'Role Delete',
            'slug' => 'role-delete'
        ]);
        // User
        $ModuleAccessControl = Module::updateOrCreate([
            'name' => 'Access Control',
            'parent_id' => 0,
            'sort_order' => 4,
            'slug' => 'access-control',
            'url' => 'access',
            'icon' => 'fas fa-copy'
        ]);

        Permission::updateOrCreate([
            'module_id' => $ModuleAccessControl->id,
            'name' => 'Access Access Control',
            'slug' => 'access-access-control'
        ]);
        $moduleUser = Module::updateOrCreate([
            'name' => 'Users',
            'parent_id' => $ModuleAccessControl->id,
            'sort_order' => 5,
            'slug' => 'user',
            'url' => 'access/users',
            'icon' => 'fas fa-users'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleUser->id,
            'name' => 'User Index',
            'slug' => 'user-index'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleUser->id,
            'name' => 'User Create',
            'slug' => 'user-create'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleUser->id,
            'name' => 'User Update',
            'slug' => 'user-update'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleUser->id,
            'name' => 'User Delete',
            'slug' => 'user-delete'
        ]);
        //Backup
        // $moduleBackup = Module::updateOrCreate([
        //     'name' => 'Backups',
        //     'name_bn' => 'ব্যাকআপ'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleBackup->id,
        //     'name' => 'Backup Index',
        //     'slug' => 'backup-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleBackup->id,
        //     'name' => 'Backup Create',
        //     'slug' => 'backup-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleBackup->id,
        //     'name' => 'Backup Update',
        //     'slug' => 'backup-download'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleBackup->id,
        //     'name' => 'Backup Delete',
        //     'slug' => 'backup-delete'
        // ]);

        //Module
        $moduleBackup = Module::updateOrCreate([
            'name' => 'Modules',
            'parent_id' => $ModuleDevConsole->id,
            'sort_order' => 6,
            'slug' => 'module',
            'url' => 'dev/modules',
            'icon' => 'fas fa-book'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleBackup->id,
            'name' => 'Module Index',
            'slug' => 'module-index'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleBackup->id,
            'name' => 'Module Create',
            'slug' => 'module-create'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleBackup->id,
            'name' => 'Module Update',
            'slug' => 'module-update'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleBackup->id,
            'name' => 'Module Delete',
            'slug' => 'module-delete'
        ]);

        //Permission
        $moduleBackup = Module::updateOrCreate([
            'name' => 'Permissions',
            'parent_id' => $ModuleDevConsole->id,
            'sort_order' => 7,
            'slug' => 'permission',
            'url' => 'dev/permissions',
            'icon' => 'fa-plus-square'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleBackup->id,
            'name' => 'Permission Index',
            'slug' => 'permission-index'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleBackup->id,
            'name' => 'Permission Create',
            'slug' => 'permission-create'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleBackup->id,
            'name' => 'Permission Update',
            'slug' => 'permission-update'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleBackup->id,
            'name' => 'Permission Delete',
            'slug' => 'permission-delete'
        ]);

        //Log
        // $moduleBackup = Module::updateOrCreate([
        //     'name' => 'Logs',
        //     'name_bn' => 'লগস'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleBackup->id,
        //     'name' => 'Log Index',
        //     'slug' => 'log-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleBackup->id,
        //     'name' => 'Log Delete',
        //     'slug' => 'log-delete'
        // ]);

        //Settings
        // $moduleBackup = Module::updateOrCreate([
        //     'name' => 'Settings',
        //     'name_bn' => 'সেটিংস'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleBackup->id,
        //     'name' => 'Setting Index',
        //     'slug' => 'setting-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleBackup->id,
        //     'name' => 'Setting Update',
        //     'slug' => 'setting-update'
        // ]);
    }
}

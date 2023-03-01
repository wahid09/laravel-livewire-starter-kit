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
            'url' => 'dev-console',
            'icon' => 'fas fa-th'
        ]);

        Permission::updateOrCreate([
            'module_id' => $ModuleDevConsole->id,
            'name' => 'Dev Console Index',
            'slug' => 'dev-console-index'
        ]);

        $moduleRole = Module::updateOrCreate([
            'name' => 'Roles',
            'parent_id' => $ModuleDevConsole->id,
            'sort_order' => 3,
            'slug' => 'role',
            'url' => 'dev-console/roles',
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
        //Data Import
        $moduleDataImport = Module::updateOrCreate([
            'name' => 'Data Import',
            'parent_id' => $ModuleDevConsole->id,
            'sort_order' => 24,
            'slug' => 'data-import',
            'url' => 'dev-console/data-imports',
            'icon' => 'fas fa-csv'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleDataImport->id,
            'name' => 'Data Import index',
            'slug' => 'data-import-index'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleDataImport->id,
            'name' => 'Data Import create',
            'slug' => 'data-import-create'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleDataImport->id,
            'name' => 'Data Import update',
            'slug' => 'data-import-update'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleDataImport->id,
            'name' => 'Data Import delete',
            'slug' => 'data-import-delete'
        ]);
        // User
        $ModuleAccessControl = Module::updateOrCreate([
            'name' => 'Access Control',
            'parent_id' => 0,
            'sort_order' => 4,
            'slug' => 'access-control',
            'url' => 'access-control',
            'icon' => 'fas fa-copy'
        ]);

        Permission::updateOrCreate([
            'module_id' => $ModuleAccessControl->id,
            'name' => 'Access Control Index',
            'slug' => 'access-control-index'
        ]);
        $moduleUser = Module::updateOrCreate([
            'name' => 'Users',
            'parent_id' => $ModuleAccessControl->id,
            'sort_order' => 5,
            'slug' => 'user',
            'url' => 'access-control/users',
            'icon' => 'fa fa-user'
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

        //Access Log
        $moduleAccessLog = Module::updateOrCreate([
            'name' => 'Access Logs',
            'parent_id' => $ModuleAccessControl->id,
            'sort_order' => 13,
            'slug' => 'access-log',
            'url' => 'access-control/access-logs',
            'icon' => 'fa fa-book'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAccessLog->id,
            'name' => 'Access Log index',
            'slug' => 'access-log-index'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAccessLog->id,
            'name' => 'Access Log create',
            'slug' => 'access-log-create'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAccessLog->id,
            'name' => 'Access Log update',
            'slug' => 'access-log-update'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAccessLog->id,
            'name' => 'Access Log delete',
            'slug' => 'access-log-delete'
        ]);

        //Login Records
        $moduleLoginRecords = Module::updateOrCreate([
            'name' => 'Login Records',
            'parent_id' => $ModuleAccessControl->id,
            'sort_order' => 14,
            'slug' => 'login-record',
            'url' => 'access-control/login-records',
            'icon' => 'fa fa-clone'
        ]);

        Permission::updateOrCreate([
            'module_id' => $moduleLoginRecords->id,
            'name' => 'Login Record index',
            'slug' => 'login-record-index'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleLoginRecords->id,
            'name' => 'Login Record create',
            'slug' => 'login-record-create'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleLoginRecords->id,
            'name' => 'Login Record update',
            'slug' => 'login-record-update'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleLoginRecords->id,
            'name' => 'Login Record delete',
            'slug' => 'login-record-delete'
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
            'url' => 'dev-console/modules',
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
            'url' => 'dev-console/permissions',
            'icon' => 'fa fa-address-card'
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

        //Application setup

        $ModuleApplicationSetup = Module::updateOrCreate([
            'name' => 'Application Setup',
            'parent_id' => 0,
            'sort_order' => 8,
            'slug' => 'application-setup',
            'url' => 'application-setup',
            'icon' => 'fa fa-cog fa-fw'
        ]);

        Permission::updateOrCreate([
            'module_id' => $ModuleApplicationSetup->id,
            'name' => 'Application Setup Index',
            'slug' => 'application-setup-index'
        ]);

        $moduleRank = Module::updateOrCreate([
            'name' => 'Ranks',
            'parent_id' => $ModuleApplicationSetup->id,
            'sort_order' => 9,
            'slug' => 'rank',
            'url' => 'application-setup/ranks',
            'icon' => 'fa fa-bars'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleRank->id,
            'name' => 'Rank Index',
            'slug' => 'rank-index'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleRank->id,
            'name' => 'Rank Create',
            'slug' => 'rank-create'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleRank->id,
            'name' => 'Rank Update',
            'slug' => 'rank-update'
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleRank->id,
            'name' => 'Rank Delete',
            'slug' => 'rank-delete'
        ]);
        // //Service
        // $moduleService = Module::updateOrCreate([
        //     'name' => 'Services',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 10,
        //     'slug' => 'service',
        //     'url' => 'application-setup/services',
        //     'icon' => 'fa fa-sticky-note'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleService->id,
        //     'name' => 'Service Index',
        //     'slug' => 'service-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleService->id,
        //     'name' => 'Service Create',
        //     'slug' => 'service-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleService->id,
        //     'name' => 'Service Update',
        //     'slug' => 'service-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleService->id,
        //     'name' => 'Service Delete',
        //     'slug' => 'service-delete'
        // ]);

        // //Division
        // $moduleSivision = Module::updateOrCreate([
        //     'name' => 'Divisions',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 11,
        //     'slug' => 'division',
        //     'url' => 'application-setup/divisions',
        //     'icon' => 'fa fa-sitemap'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSivision->id,
        //     'name' => 'Division Index',
        //     'slug' => 'division-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSivision->id,
        //     'name' => 'Division Create',
        //     'slug' => 'division-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSivision->id,
        //     'name' => 'Division Update',
        //     'slug' => 'division-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSivision->id,
        //     'name' => 'Division Delete',
        //     'slug' => 'division-delete'
        // ]);

        // //Unit
        // $moduleUnit = Module::updateOrCreate([
        //     'name' => 'Units',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 12,
        //     'slug' => 'unit',
        //     'url' => 'application-setup/units',
        //     'icon' => 'fa fa-bullhorn'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleUnit->id,
        //     'name' => 'Unit Index',
        //     'slug' => 'unit-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleUnit->id,
        //     'name' => 'Unit Create',
        //     'slug' => 'unit-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleUnit->id,
        //     'name' => 'Unit Update',
        //     'slug' => 'unit-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleUnit->id,
        //     'name' => 'Unit Delete',
        //     'slug' => 'unit-delete'
        // ]);

        // //Specifications
        // $moduleSpecification = Module::updateOrCreate([
        //     'name' => 'Specifications',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 15,
        //     'slug' => 'specification',
        //     'url' => 'application-setup/specifications',
        //     'icon' => 'fa fa-folder'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSpecification->id,
        //     'name' => 'Specification Index',
        //     'slug' => 'specification-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSpecification->id,
        //     'name' => 'Specification Create',
        //     'slug' => 'specification-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSpecification->id,
        //     'name' => 'Specification Update',
        //     'slug' => 'specification-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSpecification->id,
        //     'name' => 'Specification Delete',
        //     'slug' => 'specification-delete'
        // ]);

        // //Item Sections
        // $moduleItemSection = Module::updateOrCreate([
        //     'name' => 'Item Sections',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 16,
        //     'slug' => 'item-section',
        //     'url' => 'application-setup/item-sections',
        //     'icon' => 'fa fa-adjust'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemSection->id,
        //     'name' => 'Item Section Index',
        //     'slug' => 'item-section-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemSection->id,
        //     'name' => 'Item Section Create',
        //     'slug' => 'item-section-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemSection->id,
        //     'name' => 'Item Section Update',
        //     'slug' => 'item-section-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemSection->id,
        //     'name' => 'Item Section Delete',
        //     'slug' => 'item-section-delete'
        // ]);

        // //Account Unit
        // $moduleAccountUnit = Module::updateOrCreate([
        //     'name' => 'Account Units',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 17,
        //     'slug' => 'account-unit',
        //     'url' => 'application-setup/account-units',
        //     'icon' => 'fa fa-address-card'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleAccountUnit->id,
        //     'name' => 'Account Unit Index',
        //     'slug' => 'account-unit-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleAccountUnit->id,
        //     'name' => 'Account Unit Create',
        //     'slug' => 'account-unit-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleAccountUnit->id,
        //     'name' => 'Account Unit Update',
        //     'slug' => 'account-unit-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleAccountUnit->id,
        //     'name' => 'Account Unit Delete',
        //     'slug' => 'account-unit-delete'
        // ]);

        // //Item Group
        // $moduleItemGroup = Module::updateOrCreate([
        //     'name' => 'Item Groups',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 18,
        //     'slug' => 'item-group',
        //     'url' => 'application-setup/item-groups',
        //     'icon' => 'fa fa-bookmark'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemGroup->id,
        //     'name' => 'Item Group Index',
        //     'slug' => 'item-group-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemGroup->id,
        //     'name' => 'Item Group Create',
        //     'slug' => 'item-group-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemGroup->id,
        //     'name' => 'Item Group Update',
        //     'slug' => 'item-group-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemGroup->id,
        //     'name' => 'Item Group Delete',
        //     'slug' => 'item-group-delete'
        // ]);

        // //Item Type
        // $moduleItemType = Module::updateOrCreate([
        //     'name' => 'Item Types',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 19,
        //     'slug' => 'item-type',
        //     'url' => 'application-setup/item-types',
        //     'icon' => 'fa fa-bars'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemType->id,
        //     'name' => 'Item Type Index',
        //     'slug' => 'item-type-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemType->id,
        //     'name' => 'Item Type Create',
        //     'slug' => 'item-type-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemType->id,
        //     'name' => 'Item Type Update',
        //     'slug' => 'item-type-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemType->id,
        //     'name' => 'Item Type Delete',
        //     'slug' => 'item-type-delete'
        // ]);

        // //Item Department
        // $moduleItemDepartment = Module::updateOrCreate([
        //     'name' => 'Item Departments',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 20,
        //     'slug' => 'item-department',
        //     'url' => 'application-setup/item-departments',
        //     'icon' => 'fa fa-building'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemDepartment->id,
        //     'name' => 'Item Department Index',
        //     'slug' => 'item-department-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemDepartment->id,
        //     'name' => 'Item Department Create',
        //     'slug' => 'item-department-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemDepartment->id,
        //     'name' => 'Item Department Update',
        //     'slug' => 'item-department-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemDepartment->id,
        //     'name' => 'Item Department Delete',
        //     'slug' => 'item-department-delete'
        // ]);
        // //Pvms
        // $modulePvms = Module::updateOrCreate([
        //     'name' => 'Pvms',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 21,
        //     'slug' => 'pvm',
        //     'url' => 'application-setup/pvms',
        //     'icon' => 'fa fa-dot-circle'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemDepartment->id,
        //     'name' => 'Pvm Index',
        //     'slug' => 'pvm-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemDepartment->id,
        //     'name' => 'Pvm Create',
        //     'slug' => 'pvm-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemDepartment->id,
        //     'name' => 'Pvm Update',
        //     'slug' => 'pvm-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleItemDepartment->id,
        //     'name' => 'Pvm Delete',
        //     'slug' => 'pvm-delete'
        // ]);

        // //Supplier
        // $moduleSupplier = Module::updateOrCreate([
        //     'name' => 'Suppliers',
        //     'parent_id' => $ModuleApplicationSetup->id,
        //     'sort_order' => 23,
        //     'slug' => 'supplier',
        //     'url' => 'application-setup/suppliers',
        //     'icon' => 'fa fa-users'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSupplier->id,
        //     'name' => 'Supplier Index',
        //     'slug' => 'supplier-index'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSupplier->id,
        //     'name' => 'Supplier Create',
        //     'slug' => 'supplier-create'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSupplier->id,
        //     'name' => 'Supplier Update',
        //     'slug' => 'supplier-update'
        // ]);
        // Permission::updateOrCreate([
        //     'module_id' => $moduleSupplier->id,
        //     'name' => 'Supplier Delete',
        //     'slug' => 'supplier-delete'
        // ]);

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
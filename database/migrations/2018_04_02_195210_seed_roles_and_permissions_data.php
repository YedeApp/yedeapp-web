<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 创建权限
        Permission::create(['name' => 'manage_contents']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'write_contents']);
        Permission::create(['name' => 'edit_settings']);

        // 创建超级管理员角色，并赋予权限
        $sa = Role::create(['name' => 'SuperAdmin']);
        $sa->givePermissionTo('manage_contents');
        $sa->givePermissionTo('manage_users');
        $sa->givePermissionTo('edit_settings');

        // 创建管理员角色，并赋予权限
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo('manage_contents');

        // 创建管理员角色，并赋予权限
        $writer = Role::create(['name' => 'Writer']);
        $writer->givePermissionTo('write_contents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 清空所有数据表数据
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}

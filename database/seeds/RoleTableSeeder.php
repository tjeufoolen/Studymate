<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => Role::$ADMINISTRATOR]);
        $deadlinemanager = Role::create(['name' => Role::$DEADLINE_MANAGER]);

        // Student crud permissions
        $this->grantPermissions($this->createPermissions('student_', [
            'index',
            'create',
            'edit',
            'store',
            'update',
            'destroy'
        ]), $admin);

        // StudentTests permissions
        $this->grantPermissions($this->createPermissions('student_test_', [
            'index',
            'update'
        ]), $admin);

        // Teacher crud permissions
        $this->grantPermissions($this->createPermissions('teacher_', [
            'index',
            'show',
            'create',
            'edit',
            'store',
            'update',
            'destroy'
        ]), $admin);

        // Module crud permissions
        $this->grantPermissions($this->createPermissions('module_', [
            'index',
            'show',
            'create',
            'edit',
            'store',
            'update',
            'destroy',
            'enrollStudents'
        ]), $admin);

        // Deadline manager permissions
        $this->grantPermissions($this->createPermissions('deadlines_', [
            'deadlines',
            'nodeadlines',
            'create',
            'store',
        ]), $deadlinemanager);
    }

    private function grantPermissions($permissions, $role)
    {
        foreach ($permissions as $perm) {
            $role->grantPermission($perm);
        }
    }

    private function createPermissions($prefix, $actions)
    {
        $permissions = [];

        foreach ($actions as $action) {
            array_push($permissions, Permission::create(['name' => $prefix . $action]));
        }

        return $permissions;
    }
}

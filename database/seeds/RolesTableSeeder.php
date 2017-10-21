<?php

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role_id = config('main.seeder.admin.role_id');
        $role = Role::find($admin_role_id);
        if (!$role) {
            $role = new Role;
            $role->id = $admin_role_id;
        }

        $role->fill([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Admin that controlls everything and can access any endpoint.',
        ]);

        $role->save();

        // Get Admin user and attach admin role
        $adminUser = User::where('id', config('main.seeder.admin.id'))->first();
        $adminUser->roles()->sync([]);
        $adminUser->attachRole($role);
    }
}

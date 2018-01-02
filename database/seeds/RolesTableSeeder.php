<?php

use App\Models\Role;
use App\Models\User;
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
        // Admin Role should be always 1
        $adminRole = Role::find(1);
        $deleted = false;
        if ($adminRole && $adminRole->name != 'admin') {
            $adminRole->delete();
            $deleted = true;
        }

        if (!$adminRole || $deleted) {
            $adminRole = new Role;
            $adminRole->id = 1;
            $adminRole->name = 'admin';
            $adminRole->save();
        }

        // Now if exists, attach admin user to the role
        $adminConfig = (object) config('custom.main.seeder.admin');
        $user = User::find($adminConfig->id);
        if ($user && !$user->hasRole($adminRole)) {
            $user->assignRole($adminRole);
        }
    }
}

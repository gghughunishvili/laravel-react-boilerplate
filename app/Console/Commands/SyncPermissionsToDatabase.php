<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;

class SyncPermissionsToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all permissions from config to db and update admin roles to have all permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * if permissions haven't changed this command won't update permissions
     * It drops all admin permissions' connection and then adds all of them back again
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Started permissions syncing");

        $this->dropAllAdminPermissions();

        $permissions = config('custom.permissions');

        $syncedPermissions = collect([]);

        foreach ($permissions as $wrapper => $subPermissions) {
            foreach ($subPermissions as $permission => $id) {
                $name = $permission . "-" . $wrapper;
                $existedPermission = Permission::find($id);
                if ($existedPermission && $name == $existedPermission->name) {
                    // If exact permission exists in db
                    $syncedPermissions->push($id);
                    continue;
                }

                if ($existedPermission) {
                    $existedPermission->delete();
                }

                // Also should be deleted if exists by this name
                $existedIdPermission = Permission::where('name', $name)->first();
                if ($existedIdPermission) {
                    $existedIdPermission->delete();
                }

                $newPermission = $this->createAndSaveNewPermission($id, $name);
                $syncedPermissions->push($id);
            }
        }

        $this->deleteMismatchedPermissions($syncedPermissions);

        $this->attachAllPermissionsToAdmin();
        $this->info("Permissions sync has finished succesfully!");
    }

    protected function dropAllAdminPermissions()
    {
        $adminRole = Role::getByName('admin');
        if ($adminRole) {
            $adminRole->syncPermissions([]);
        }
    }

    protected function attachAllPermissionsToAdmin()
    {
        $adminRole = Role::getByName('admin');
        if ($adminRole) {
            $permissions = Permission::all();
            $adminRole->givePermissionTo($permissions);
        }
    }

    protected function createAndSaveNewPermission($id, $name)
    {
        $newPermission = new Permission();
        $newPermission->name = $name;
        $newPermission->id = $id;
        $newPermission->save();
        return $newPermission;
    }

    protected function deleteMismatchedPermissions($syncedPermissions)
    {
        Permission::whereNotIn('id', $syncedPermissions)->delete();
    }
}

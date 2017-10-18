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
        $deleteDiffPermissions = $this->confirm(
            'Do you wish to delete permissions that aren\'t in permissions\' config (default no)?'
        );

        $this->info("Started permissions syncing");

        $this->dropAllAdminPermissions();

        $permissions = config('permissions');
        $syncedPermissions = collect([]);
        foreach ($permissions as $permission) {

            $existedPermission = Permission::getByName($permission['name']);

            if ($existedPermission) {
                if (isset($permission['display_name'])) {
                    $existedPermission->display_name = $permission['display_name'];
                }
                if (isset($permission['description'])) {
                    $existedPermission->description = $permission['description'];
                }
                $existedPermission->save();
                $syncedPermissions->push($existedPermission->id);
                continue;
            }

            $newPermission = $this->createAndSaveNewPermission($permission);
            $syncedPermissions->push($newPermission->id);
        }

        if ($deleteDiffPermissions) {
            $this->deleteMismatchedPermissions($syncedPermissions);
        }

        $this->attachAllPermissionsToAdmin();

        $this->info("Permissions sync has finished succesfully!");
    }

    protected function dropAllAdminPermissions()
    {
        $admin_role = Role::getByName('admin');
        $admin_role->perms()->sync([]);
    }

    protected function attachAllPermissionsToAdmin()
    {
        $admin_role = Role::getByName('admin');
        $permissions = Permission::all();
        $admin_role->attachPermissions($permissions);
    }

    protected function createAndSaveNewPermission($permission)
    {
        $newPermission = new Permission();
        $newPermission->name = $permission['name'];

        if (isset($permission['description'])) {
            $newPermission->description = $permission['description'];
        }else{
            $newPermission->display_name = $this->getDisplayNameFromName($permission['name']);
        }

        $newPermission->description = $newPermission->display_name;

        if (isset($permission['description'])) {
            $newPermission->description = $permission['description'];
        }

        $newPermission->save();

        return $newPermission;
    }

    protected function getDisplayNameFromName($name)
    {
        $nameCollection = collect(explode('-', $name));
        $nameCollection->transform(function ($item, $key) {
            return ucfirst($item);
        });
        return $nameCollection->implode(' ');
    }

    protected function deleteMismatchedPermissions($syncedPermissions)
    {
        Permission::whereNotIn('id', $syncedPermissions)->delete();
    }
}

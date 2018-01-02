<?php

/*
|--------------------------------------------------------------------------
| All Permissions
|--------------------------------------------------------------------------
|
| Here will be listed all the permissions that app will use.
| This permissions will be attached to admin when command will run
| A name always must be separated by dashes
| In project exists command sync:permissions that will sync all permissions to db
|
*/

$permissions = [];

// Role
$permissions['role']['create'] = 1;
$permissions['role']['get'] = 2;
$permissions['role']['find'] = 3;
$permissions['role']['delete'] = 4;
$permissions['role']['find-permissions-for'] = 5;
$permissions['role']['attach-permission-to'] = 6;
$permissions['role']['detach-permission-from'] = 7;

// Permission
$permissions['permission']['find'] = 8;

// User
$permissions['user']['create'] = 9;
$permissions['user']['update'] = 10;
$permissions['user']['update-any'] = 11;
$permissions['user']['update-status-of'] = 12;
$permissions['user']['get'] = 13;
$permissions['user']['get-any'] = 14;
$permissions['user']['find'] = 15;
$permissions['user']['delete'] = 16;
$permissions['user']['find-roles-for'] = 17;
$permissions['user']['attach-role-to'] = 18;
$permissions['user']['detach-role-from'] = 19;

return $permissions;

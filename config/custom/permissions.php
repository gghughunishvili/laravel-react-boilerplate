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

$permissions['role']['create'] = 1;
$permissions['role']['get'] = 2;
$permissions['role']['find'] = 3;
$permissions['role']['delete'] = 4;
$permissions['role']['attach-permission'] = 5;

$permissions['user']['create'] = 6;
$permissions['user']['update'] = 7;
$permissions['user']['get'] = 8;
$permissions['user']['find'] = 9;
$permissions['user']['delete'] = 10;

return $permissions;

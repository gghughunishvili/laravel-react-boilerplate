<?php

return [

    /*
    |--------------------------------------------------------------------------
    | All Permissions
    |--------------------------------------------------------------------------
    |
    | Here will be listed all the permissions that app will use.
    | This permissions will be attached to admin when command will run
    | A name always must be separated by dashes
    | Recommended permission name: [action name]-[resource name]-[some optional stuff]
    | In project exists command sync:permissions that will sync all permissions to db,
    | and it will create display_name by itself if not provided,
    | also if description not provided it will be copied from display_name
    |
    */


   // Permissions
    [
        'name' => 'create-permissions',
    ],
    [
        'name' => 'update-permissions',
        'description' => 'Update permissions resource, that updates only description and display name',
    ],
    [
        'name' => 'find-permissions',
    ],
    [
        'name' => 'get-permissions',
        'description' => 'Get all permissions',
    ],
    [
        'name' => 'delete-permissions',
    ],


    // Roles
    [
        'name' => 'create-roles',
    ],
    [
        'name' => 'update-roles',
    ],
    [
        'name' => 'find-roles',
    ],
    [
        'name' => 'get-roles',
    ],
    [
        'name' => 'delete-roles',
    ],
    [
        'name' => 'add-permissions-to-roles',
    ],
    [
        'name' => 'remove-permissions-from-roles',
    ],
    [
        'name' => 'add-roles-to-users',
    ],
    [
        'name' => 'remove-roles-from-users',
    ],


    // Users
    [
        'name' => 'update-users'
    ],
    [
        'name' => 'get-users',
        'display_name' => 'Get Users',
        'description' => 'To get any user with given ID and other parameters',
    ],
    [
        'name' => 'get-passive-users',
        'description' => 'To get any passive user',
    ],
    [
        'name' => 'delete-users',
        'description' => 'To delete any user from db',
    ],

];

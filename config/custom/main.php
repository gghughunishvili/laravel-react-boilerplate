<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Seeder info
    |--------------------------------------------------------------------------
    |
    | All necessary information that's necessary for app testing
    | Admin role ID always should be presented and never changed in order to app work as expected
    */

    'seeder' => [
        'admin' => [
            'role_id' => '1b3aaa64-917f-4b21-9ac5-c3ccd9df7867',
            'id' => 'ae1f9f14-6c4d-43df-a47f-cd9c184265f2',
            'name' => 'Admin Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => '123456',
        ],

        'test' => [
            'id' => '08e12d56-6913-44fd-bbd9-5f14306af501',
            'name' => 'Test User',
            'username' => 'test',
            'email' => 'test@example.com',
            'password' => '123456',
        ],

        'passport' => [
            'client_id' => 1,
            'client_secret' => 'Hcm8ofEYEbczMedOOrSF5DxrqQbO79zJDCeqZEeT',
        ],
    ],
];

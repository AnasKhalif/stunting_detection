<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadmin' => [
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'reports' => 'c,r,u,d',
            'consultations' => 'c,r,u,d',
            'articles' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'admin' => [
            'users' => 'r,u',
            'reports' => 'c,r,u,d',
            'children' => 'c,r,u,d',
            'articles' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'tenaga_kesehatan' => [
            'consultations' => 'c,r,u,d',
            'children' => 'r',
            'monitoring' => 'r,u',
            'profile' => 'r,u',
        ],
        'user' => [
            'children' => 'c,r,u,d',
            'detections' => 'c,r,u,d',
            'monitoring' => 'r',
            'consultations' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];

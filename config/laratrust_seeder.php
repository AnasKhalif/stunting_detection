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
            'dashboard' => 'r',
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'articles' => 'c,r,u,d',
            'faqs' => 'c,r,u,d',
            'foods' => 'c,r,u,d',
            'children' => 'c,r,u,d',
            'reports' => 'r',
            'stunting' => 'c,r',
            'monitoring' => 'r',
            'consultations' => 'c,r,u,d',
            'profile' => 'r,u',
            'log-system' => 'r',
        ],
        'admin' => [
            'dashboard' => 'r',
            'users' => 'c,r,u,d',
            'articles' => 'c,r,u,d',
            'faqs' => 'c,r,u,d',
            'foods' => 'c,r,u,d',
            'children' => 'r,u',
            'reports' => 'r',
            'monitoring' => 'r',
            'profile' => 'r,u',
        ],
        'dokter' => [
            'dashboard' => 'r',
            'consultations' => 'c,r,u,d',
            'children' => 'r',
            'monitoring' => 'r,u',
            'foods' => 'r',
            'stunting' => 'r',
            'profile' => 'r,u',
        ],
        'health_worker' => [
            'dashboard' => 'r',
            'consultations' => 'c,r,u,d',
            'children' => 'r',
            'monitoring' => 'r,u',
            'foods' => 'r',
            'stunting' => 'r',
            'profile' => 'r,u',
        ],
        'orang_tua' => [
            'dashboard' => 'r',
            'children' => 'c,r,u,d',
            'stunting' => 'c,r',
            'monitoring' => 'r',
            'consultations' => 'c,r,u,d',
            'foods' => 'r',
            'profile' => 'r,u',
        ],
        'user' => [
            'dashboard' => 'r',
            'children' => 'c,r,u,d',
            'stunting' => 'c,r',
            'monitoring' => 'r',
            'consultations' => 'c,r,u,d',
            'foods' => 'r',
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

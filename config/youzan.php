<?php

return [
    // Default app name
    'default_app' => 'default',

    // Base configuration
    'base' => [
        'debug' => true,
        'log' => [
            'name' => 'youzan',
            'file' => storage_path('logs/youzan.log'),
            'level' => 'debug',
            'permission' => 0777,
        ]
    ],

    // Applications
    'apps' => [
        'default' => [
            'client_id' => config('services.youzan.clientid'),
            'client_secret' => config('services.youzan.secret'),
            'type' => \Hanson\Youzan\Youzan::PERSONAL, // 自用型应用
            'kdt_id' => config('services.youzan.kdtid'), // store_id
        ],
        // 'another_app' => [
        //     'client_id' => 'XXXXXXXXX',
        //     'client_secret' => 'XXXXXXXXX',
        //     'redirect_uri' => 'http://YOURSITE.com/',
        // ],
        //
        // 'platform_app' => [
        //     'client_id' => '',
        //     'client_secret' => '',
        //     'type' => \Hanson\Youzan\Youzan::PLATFORM,
        // ],
    ]
];
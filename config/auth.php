<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'createurs_de_qr',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'createurs_de_qr',
        ],
    ],

    'providers' => [
        'createurs_de_qr' => [
            'driver' => 'eloquent',
            'model' => \App\Models\CreateurDeQr::class
        ]
    ]
];
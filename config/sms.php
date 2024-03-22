<?php

return [
    'default' => env('SMS_PROVIDER', 'mock_provider_1'),
    'providers' => [
        'mock_provider_1' => [
            'url' => 'https://run.mocky.io/v3/8eb88272-d769-417c-8c5c-159bb023ec0a',
        ],
        'mock_provider_2' => [
            'url' => 'https://run.mocky.io/v3/268d1ff4-f710-4aad-b455-a401966af719',
        ],
    ],
];


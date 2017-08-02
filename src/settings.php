<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings

        'api_url' => 'https://geocode-maps.yandex.ru/1.x/',
        'api_data_url' => '',
        'uploadServiceUrl' => 'http://104.198.149.144:8080/',
        'api_static_map_url' => 'https://static-maps.yandex.ru/1.x/'
    ],
];

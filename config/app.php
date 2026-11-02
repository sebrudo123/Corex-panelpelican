<?php

return [

    'name' => env('APP_NAME', 'Corex'),
    'logo' => env('APP_LOGO', '/corex.svg'),
    'favicon' => env('APP_FAVICON', '/corex.svg'),

    'version' => 'canary',

    'timezone' => 'UTC',

    'installed' => env('APP_INSTALLED', true),

    'exceptions' => [
        'report_all' => env('APP_REPORT_ALL_EXCEPTIONS', false),
    ],

    'fallback_locale' => 'en',

];

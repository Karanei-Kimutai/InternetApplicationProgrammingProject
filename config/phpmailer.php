<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Transport Layer Settings
    |--------------------------------------------------------------------------
    |
    | Only SMTP is supported for now because it keeps the configuration explicit,
    | but the service gracefully falls back to PHP's mail() when transport
    | equals "mail".
    |
    */
    'transport' => env('PHPMAILER_TRANSPORT', 'smtp'),
    'host' => env('PHPMAILER_HOST', env('MAIL_HOST', '127.0.0.1')),
    'port' => (int) env('PHPMAILER_PORT', env('MAIL_PORT', 2525)),
    'encryption' => env('PHPMAILER_ENCRYPTION', env('MAIL_ENCRYPTION')),
    'username' => env('PHPMAILER_USERNAME', env('MAIL_USERNAME')),
    'password' => env('PHPMAILER_PASSWORD', env('MAIL_PASSWORD')),
    'timeout' => (int) env('PHPMAILER_TIMEOUT', 10),
    'verify_peer' => filter_var(env('PHPMAILER_VERIFY_PEER', true), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? true,
    'debug' => (bool) env('PHPMAILER_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Default Sender
    |--------------------------------------------------------------------------
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'no-reply@example.com'),
        'name' => env('MAIL_FROM_NAME', env('APP_NAME', 'Temporary Pass Office')),
    ],
];

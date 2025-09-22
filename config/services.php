<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'reniec' => [
        'token_apis_net_pe' => env('TOKEN_APIS_NET_PE'),
        'token_apis_peru' => env('TOKEN_APIS_PERU'),
        'token_apis_migo' => env('TOKEN_APIS_MIGO'),
        'token_apis_peru_fact' => env('TOKEN_APIS_PERU_FACT'),
        'token_apis_aqpfact' => env('TOKEN_APIS_AQPFACT'),
        'token_apis_peru_dev' => env('TOKEN_APIS_PERU_DEV'),
        'token_apis_diurvan' => env('TOKEN_APIS_DIURVAN'),
        'apis_net_pe' => env('RENIEC_APIS_NET_PE'),
        'mi_api' => [
            'token' => env('RENIEC_MI_API_TOKEN'),
        ],
    ],

    'data' => [
        'token' => env('TOKEN_CONSULTA'),
        'endpoint' => env('ENDPOINT_CONSULTA'),
    ],

];

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    | Server Key & Client Key diperoleh dari Dashboard Midtrans:
    | https://dashboard.sandbox.midtrans.com/settings/access_keys
    */

    'merchant_id'   => env('MIDTRANS_MERCHANT_ID', 'M679471441'),
    'server_key'    => env('MIDTRANS_SERVER_KEY', ''),
    'client_key'    => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', !str_starts_with(env('MIDTRANS_SERVER_KEY', ''), 'SB-')),
    'is_sanitized'  => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds'        => env('MIDTRANS_IS_3DS', true),
];

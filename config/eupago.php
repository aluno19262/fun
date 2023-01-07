<?php
return [
    'enable_mb' => env('EUPAGO_ENABLE_MB', false),
    'key' => env('EUPAGO_KEY', null),
    'sandbox' => env('EUPAGO_SANDBOX', true),
    'callback_url' => env('EUPAGO_CALLBACK_URL', "")
];

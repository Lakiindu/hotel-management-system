<?php

return [
    'merchant_id' => env('PAYHERE_MERCHANT_ID'),
    'merchant_secret' => env('PAYHERE_MERCHANT_SECRET'),
    'sandbox' => env('PAYHERE_SANDBOX', true),

    'checkout_url' => env('PAYHERE_SANDBOX', true)
        ? 'https://sandbox.payhere.lk/pay/checkout'
        : 'https://www.payhere.lk/pay/checkout',
];
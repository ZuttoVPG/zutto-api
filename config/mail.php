<?php

return [
    'driver' => env('MAIL_DRIVER', 'log'),
    'from' => [
        'address' => ENV('MAIL_FROM_ADDR'),
        'name' => ENV('MAIL_FROM_ADDR_PRETTY'),
    ],
];

<?php

return [
    'sparkpost' => [
        'secret' => ENV('SPARKPOST_API_KEY'),
        'return_path' => ENV('MAIL_BOUNCE_DOMAIN'), 
    ],
];

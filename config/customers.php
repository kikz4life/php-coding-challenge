<?php

return [
    'data_provider_url' => env('CUSTOMER_API_URL', 'https://randomuser.me/api/'),
    'nationality' => env('CUSTOMER_NATIONALITY', 'AU'),
    'customer_fetch_count' => env('CUSTOMER_FETCH_COUNT', 100),
];

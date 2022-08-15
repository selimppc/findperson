<?php

return [
    'CACHE_EXPIRES_IN' => env('CACHE_EXPIRES_IN', 60), // in seconds
    'PAGINATION_LIMIT' => env('PAGINATION_LIMIT', 20),
    'CSV_DATA_FILE_KEY' => env('CSV_DATA_FILE_KEY', 'data/test-data.csv'),
];

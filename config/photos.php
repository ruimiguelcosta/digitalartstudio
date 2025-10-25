<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Photo Upload Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for photo uploads,
    | including size limits and count limits per upload.
    |
    */

    'max_size_mb' => env('PHOTO_MAX_SIZE_MB', 20),
    'max_count' => env('PHOTO_MAX_COUNT', 10),
];

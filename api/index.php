<?php

// Prepare /tmp storage for Vercel Serverless environment
$tmpStorage = '/tmp/storage';
foreach ([
    "$tmpStorage/framework/views",
    "$tmpStorage/framework/sessions",
    "$tmpStorage/framework/cache",
    "$tmpStorage/logs",
    '/tmp/bootstrap/cache'
] as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Forward Vercel serverless requests to public/index.php
require __DIR__ . '/../public/index.php';

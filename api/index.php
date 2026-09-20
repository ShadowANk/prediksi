<?php

// Enable error reporting for debugging Vercel deployment
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

putenv('APP_DEBUG=true');
$_ENV['APP_DEBUG'] = 'true';
$_SERVER['APP_DEBUG'] = 'true';

// Set APP_KEY fallback if missing
if (empty($_ENV['APP_KEY']) && empty(getenv('APP_KEY'))) {
    $key = 'base64:UtHyzibyBFTkitdqxZfnPuGj2OT5nFIzshyW4394gq0=';
    putenv("APP_KEY=$key");
    $_ENV['APP_KEY'] = $key;
    $_SERVER['APP_KEY'] = $key;
}

// Clean stale dev-mode cached files from bootstrap/cache if present
foreach (['packages.php', 'services.php', 'config.php', 'routes.php'] as $staleFile) {
    $filePath = __DIR__ . "/../bootstrap/cache/$staleFile";
    if (file_exists($filePath)) {
        @unlink($filePath);
    }
}

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

try {
    // Forward Vercel serverless requests to public/index.php
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Vercel Deployment Error Debugger</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")</p>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

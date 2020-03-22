<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

// Prepare PHP environment
ini_set('display_errors', '1');
error_reporting(E_ALL);
ini_set('log_errors', '0');
ini_set('assert.exception', '1');

// Enable Symfony debug tools
Symfony\Component\ErrorHandler\Debug::enable();
Symfony\Component\ErrorHandler\ErrorHandler::register();
Symfony\Component\ErrorHandler\DebugClassLoader::enable();

// Define Mockery global helpers
Mockery::globalHelpers();

// Require spec files
foreach (new DirectoryIterator(__DIR__ . '/spec') as $fileInfo) {
    if ($fileInfo->isDot()) {
        continue;
    }
    /** @psalm-suppress UnresolvableInclude */
    require_once $fileInfo->getPathname();
}

// Run Mockery expectations
Mockery::close();

// Still here?
echo "All good!\n";

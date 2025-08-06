<?php

$vendorFolder = __DIR__ . '/vendor';
$autoloadFile = $vendorFolder . '/autoload.php';

if (!file_exists($vendorFolder) || !file_exists($autoloadFile)) {
    require_once __DIR__ . '/maintenance.php';
    exit;
}

require_once $autoloadFile;
require_once __DIR__ . '/login.php';
<?php

$composerAutoload = __DIR__ . '/vendor/autoload.php';

if (!file_exists($composerAutoload)) {
    header('Location: maintenance.php');
    exit;
}

header('Location: login.php');
exit;
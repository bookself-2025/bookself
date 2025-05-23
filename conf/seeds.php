<?php

if (!defined('ABSPATH')) {
    exit;
}

return [
    'isPlugin'             => true,
    'removeOnDeactivation' => false,
    'mainFile'             => BOOKSELF_MAIN,
    'terms'                => __DIR__ . '/seed-terms.php',
];

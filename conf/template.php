<?php

if (!defined('ABSPATH')) {
    exit;
}

return [
    'extensions' => ['php'],
    'infix'      => 'tmpl',
    'scopes'     => [
        plugin_dir_path(BOOKSELF_MAIN) . '/inc/templates',
    ],
];

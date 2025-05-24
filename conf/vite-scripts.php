<?php

if (!defined('ABSPATH')) {
    exit;
}

return [
    'distBaseUrl'  => plugin_dir_url(BOOKSELF_MAIN) . 'dist',
    'i18n'         => false,
    'isProd'       => 'production' === wp_get_environment_type(),
    'manifestPath' => plugin_dir_path(BOOKSELF_MAIN) . 'dist/.vite/manifest.json'
];

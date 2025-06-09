<?php

if (!defined('ABSPATH')) {
    exit;
}

return [
    'devServerUrl' => 'https://localhost:5173/',
    'distBaseUrl'  => plugin_dir_url(BOOKSELF_MAIN) . 'dist',
    'i18n'         => false,
    'isProd'       => 'production' === wp_get_environment_type(),
    'manifestPath' => plugin_dir_path(BOOKSELF_MAIN) . 'dist/.vite/manifest.json',
];

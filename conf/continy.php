<?php

use Bookself\Bookself\Modules;
use Bojaghi\Continy\Continy;

if (!defined('ABSPATH')) {
    exit;
}

return [
    'main_file' => BOOKSELF_MAIN,
    'version'   => BOOKSELF_VERSION,
    'hooks'     => [
        'admin_init'    => 0,
        'init'          => 0,
        'rest_api_init' => 0,
    ],
    'bindings'  => [
        // Bojaghi side
        'bojaghi/customPosts'      => Bojaghi\CustomPosts\CustomPosts::class,
        'bojaghi/scripts'          => Bojaghi\Scripts\Script::class,
        'bojaghi/template'         => Bojaghi\Template\Template::class,
        // Plugin side
        'bookself/admin/edit'      => Modules\Admin\Edit::class,
        'bookself/admin/metaBoxes' => Modules\Admin\MetaBoxes::class,
        'bookself/postMeta'        => Modules\PostMeta::class,
    ],
    'arguments' => [
        // Bojaghi side
        'bojaghi/customPosts' => __DIR__ . '/custom-posts.php',
        'bojaghi/scripts'     => __DIR__ . '/scripts.php',
        'bojaghi/template'    => __DIR__ . '/template.php',
        // Plugin side
        'bookself/postMeta'   => __DIR__ . '/post-meta.php',
    ],
    'modules'   => [
        '_'             => [
        ],
        'init'          => [
            Continy::PR_HIGH    => [
                // Bojaghi side
                'bojaghi/customPosts',
                // Plugin side
                'bookself/postMeta',
            ],
            Continy::PR_DEFAULT => [
                // Bojaghi side
                'bojaghi/scripts',
                // Plugin side
                'bookself/admin/metaBoxes',
            ],
            Continy::PR_LOW     => [
                // Plugin side
                'bookself/admin/edit'
            ]
        ],
        'admin_init'    => [
            Continy::PR_DEFAULT => [
                // Plugin side
            ],
        ],
        'rest_api_init' => [
            Continy::PR_DEFAULT => [
            ],
        ],
    ],
];

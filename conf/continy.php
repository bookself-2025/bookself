<?php

use Bookself\Bookself\Modules;
use Bookself\Bookself\Supports;
use Bojaghi\Continy\Continy;

if (!defined('ABSPATH')) {
    exit;
}

return [
    'main_file' => BOOKSELF_MAIN,
    'version'   => BOOKSELF_VERSION,
    'hooks'     => [
        'admin_init'    => 0,
        'admin_menu'    => 0,
        'do_meta_boxes' => 0,
        'init'          => 0,
        'rest_api_init' => 0,
    ],
    'bindings'  => [
        // Bojaghi side
        'bojaghi/adminMenus'         => Bojaghi\AdminMenus\AdminMenus::class,
        'bojaghi/cleanPages'         => Bojaghi\CleanPages\CleanPages::class,
        'bojaghi/customPosts'        => Bojaghi\CustomPosts\CustomPosts::class,
        'bojaghi/customTax'          => Bojaghi\Tax\CustomTaxonomies::class,
        'bojaghi/metaBoxes'          => Bojaghi\MetaBoxes\MetaBoxes::class,
        'bojaghi/scripts'            => Bojaghi\Scripts\Script::class,
        'bojaghi/seeds'              => Bojaghi\SeedObjects\SeedsObjects::class,
        'bojaghi/template'           => Bojaghi\Template\Template::class,
        'bojaghi/viteScripts'        => Bojaghi\ViteScripts\ViteScript::class,
        // Plugin side
        'bookself/admin/edit'        => Modules\Admin\Edit::class,
        'bookself/api/book'          => Modules\Api\Book::class,
        'bookself/options'           => Modules\Options::class,
        'bookself/postMeta'          => Modules\PostMeta::class,
        // Plugin supports
        'bookself/admin/bookSupport' => Supports\Admin\BookSupport::class,
    ],
    'arguments' => [
        // Bojaghi side
        'bojaghi/adminMenus'       => __DIR__ . '/admin-menus.php',
        'bojaghi/cleanPages'       => __DIR__ . '/clean-pages.php',
        'bojaghi/customPosts'      => __DIR__ . '/custom-posts.php',
        'bojaghi/customTax'        => __DIR__ . '/custom-tax.php',
        'bojaghi/metaBoxes'        => __DIR__ . '/meta-boxes.php',
        'bojaghi/scripts'          => __DIR__ . '/scripts.php',
        'bojaghi/seeds'            => __DIR__ . '/seeds.php',
        'bojaghi/template'         => __DIR__ . '/template.php',
        'bojaghi/viteScripts'      => __DIR__ . '/vite-scripts.php',
        // Plugin side
        'bookself/options'         => __DIR__ . '/options.php',
        'bookself/postMeta'        => __DIR__ . '/post-meta.php',

        // Supports
        Supports\Api\Aladin::class => fn() => [bookselfGet(Modules\Options::class)->ttbKey->get()],
    ],
    'modules'   => [
        '_'             => [
            'bojaghi/cleanPages',
            'bojaghi/seeds',
        ],
        'admin_menu'    => [
            Continy::PR_DEFAULT => [
                'bojaghi/adminMenus',
            ],
        ],
        'do_meta_boxes' => [
            Continy::PR_VERY_LOW => [
                'bojaghi/metaBoxes',
            ],
        ],
        'init'          => [
            Continy::PR_HIGH    => [
                // Bojaghi side
                'bojaghi/customPosts',
                'bojaghi/customTax',
                // Plugin side
                'bookself/postMeta',
                'bookself/options',
            ],
            Continy::PR_DEFAULT => [
                // Bojaghi side
                'bojaghi/scripts',
            ],
            Continy::PR_LOW     => [
                // Bojaghi side
                // Plugin side
                'bookself/admin/edit',
            ],
        ],
        'admin_init'    => [
            Continy::PR_DEFAULT => [
                // Plugin side
            ],
        ],
        'rest_api_init' => [
            Continy::PR_DEFAULT => [
                'bookself/api/book',
            ],
        ],
    ],
];

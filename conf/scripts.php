<?php

if (!defined('ABSPATH')) {
    exit;
}

$ver = 'production' === wp_get_environment_type() ? BOOKSELF_VERSION : time();

return [
    'scripts' => [
        'items'         => [
            [
                'handle' => 'bookself-livereload',
                'src'    => 'http://localhost:35729/livereload.js?sipver=1',
                'ver'    => null,
                'args'   => ['in_footer' => true],
            ],
        ],
        'admin_enqueue' => [
            'bookself-livereload' => function ($handle, $hook): bool {
                global $post_type;

                return (
                    BOOKSELF_CPT_BOOK === $post_type &&
                    ('post.php' === $hook || 'post-new.php' === $hook) &&
                    'production' !== wp_get_environment_type()
                );
            },
        ],
    ],
    'styles'  => [
        'items'         => [
            [
                'handle' => 'bookself-admin-edit-book',
                'src'    => plugins_url('assets/admin-edit-book.css', BOOKSELF_MAIN),
                'ver'    => $ver,
            ],
        ],
        'admin_enqueue' => [
            'bookself-admin-edit-book' => function ($handle, $hook): bool {
                global $post_type;
                return (
                    BOOKSELF_CPT_BOOK === $post_type &&
                    ('post.php' === $hook || 'post-new.php' === $hook || 'edit.php' === $hook)
                );
            },
        ],
    ],
];

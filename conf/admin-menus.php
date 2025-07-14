<?php

use Bookself\Bookself\Supports\Admin\Settings;

if (!defined('ABSPATH')) {
    exit;
}

return [
    'add_submenu' => [
        [
            'parent_slug' => 'options-general.php',
            'page_title'  => '북셀프 설정 페이지',
            'menu_title'  => '북셀프 설정',
            'capability'  => 'manage_options',
            'menu_slug'   => BOOKSELF_SETTINGS_PAGE,
            'callback'    => fn() => bookselfCall(Settings::class, 'render'),
        ],
    ],
    'remove_menu' => [
        'edit.php',
        'edit-comments.php',
    ],
];

<?php

use Bookself\Bookself\Supports\FrontPage;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @uses FrontPage::checkCondition
 * @uses FrontPage::before
 * @uses FrontPage::render
 */
return [
    [
        'name' => 'bookself',
        'condition' => fn() => is_page('bookself'),
        'before'    => function () { bookselfCall(FrontPage::class, 'before'); },
        'body'      => function () { bookselfCall(FrontPage::class, 'render'); },
    ],
    'show_admin_bar' => true,
];

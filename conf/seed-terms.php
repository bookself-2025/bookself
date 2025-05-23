<?php

if (!defined('ABSPATH')) {
    exit;
}

// Register taxnomy before adding therms.
bookselfGet('bojaghi/customTax');

return [
    [
        'taxonomy' => BOOKSELF_TAX_OWN,
        'name'     => __('소장', 'bookself'),
        'slug'     => 'own',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_OWN,
        'name'     => __('대여', 'bookself'),
        'slug'     => 'borrow',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_OWN,
        'name'     => __('판매', 'bookself'),
        'slug'     => 'sold',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_OWN,
        'name'     => __('구매희망', 'bookself'),
        'slug'     => 'wish',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_READ,
        'name'     => __('읽기 전', 'bookself'),
        'slug'     => 'not-read',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_READ,
        'name'     => __('읽는 중', 'bookself'),
        'slug'     => 'reading',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_READ,
        'name'     => __('읽음', 'bookself'),
        'slug'     => 'read',
    ],
];

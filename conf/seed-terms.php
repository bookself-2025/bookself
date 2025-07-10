<?php

if (!defined('ABSPATH')) {
    exit;
}

// Register taxnomy before adding therms.
bookselfGet('bojaghi/customTax');

/**
 * // 택소노미: 소유 상태
 * - 소유
 *   - 소장 중
 *   - 대여 중
 *   - 판매 희망
 * - 미소유
 *
 * // 택소노미: 독서 성태
 * - 읽기 전
 * - 읽는 중
 * - 다 읽음
 */
return [
    [
        'taxonomy' => BOOKSELF_TAX_OWN,
        'name'     => __('소유', 'bookself'),
        'slug'     => 'own',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_OWN,
        'name'     => __('미소유', 'bookself'),
        'slug'     => 'not-own',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_OWN,
        'name'     => __('소장 중', 'bookself'),
        'slug'     => 'own-by-me',
        'parent'   => 'own',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_OWN,
        'name'     => __('대여 중', 'bookself'),
        'slug'     => 'own-borrowed',
        'parent'   => 'own',
    ],
    [
        'taxonomy' => BOOKSELF_TAX_OWN,
        'name'     => __('판매 희망', 'bookself'),
        'slug'     => 'own-want-to-sell',
        'parent'   => 'own',
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
        'name'     => __('다 읽음', 'bookself'),
        'slug'     => 'read-all',
    ],
];

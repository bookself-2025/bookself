<?php

use Bojaghi\MetaBoxes\MetaBoxes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @uses \Bookself\Bookself\Supports\Admin\BookSupport::renderBookProperties()
 * @uses \Bookself\Bookself\Supports\Admin\BookSupport::renderBookStati()
 */
return [
    'add'     => [
        [
            'id'       => 'bookself-book-properties',
            'title'    => __('도서 속성', 'bookself'),
            'callback' => bookself()->parseCallback('bookself/admin/bookSupport@renderBookProperties'),
            'screen'   => BOOKSELF_CPT_BOOK,
            'context'  => MetaBoxes::CONTEXT_SIDE,
            'priority' => MetaBoxes::PRIORITY_LOW,
        ],
        [
            'id'       => 'bookself-book-stati',
            'title'    => __('소장 상태', 'bookself'),
            'callback' => bookself()->parseCallback('bookself/admin/bookSupport@renderBookStati'),
            'screen'   => BOOKSELF_CPT_BOOK,
            'context'  => MetaBoxes::CONTEXT_SIDE,
            'priority' => MetaBoxes::PRIORITY_LOW,
        ],
    ],
    'remove'  => [
        // Remove built-in taxonomy metaboxes
        [
            'id'      => 'bookself_owndiv',       // Required
            'screen'  => BOOKSELF_CPT_BOOK,       // Required
            'context' => MetaBoxes::CONTEXT_SIDE, // Required
        ],
        [
            'id'      => 'tagsdiv-bookself_read', // Required
            'screen'  => BOOKSELF_CPT_BOOK,       // Required
            'context' => MetaBoxes::CONTEXT_SIDE, // Required
        ],
    ],
];

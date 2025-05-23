<?php

namespace Bookself\Bookself\Modules\Admin;

use Bojaghi\Contract\Module;
use Bookself\Bookself\Supports\Admin\BookProperties;
use WP_Post;

class MetaBoxes implements Module
{
    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'addMetaBoxes']);
    }

    public function addMetaBoxes(): void
    {
        add_meta_box(
            'bookself-book-properties',
            __('도서 속성', 'bookself'),
            [$this, 'outputMetaBoxes'],
            null,
            'side',
            'low',
        );
    }

    /**
     * @param WP_Post $post
     * @param array   $args
     *
     * @return void
     *
     * @uses BookProperties::renderMetaBox
     */
    public function outputMetaBoxes(WP_Post $post, array $args): void
    {
        if (empty($args['id'])) {
            return;
        }

        $id = $args['id'];

        if ('bookself-book-properties' === $id) {
            bookselfCall(BookProperties::class, 'renderMetaBox', [$post]);
        }
    }
}
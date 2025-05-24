<?php

namespace Bookself\Bookself\Modules\Admin;

use Bojaghi\Contract\Module;
use Bookself\Bookself\Supports\Admin\BookSupport;
use WP_Post;

class MetaBoxes implements Module
{
    public function __construct()
    {
        $post_type = BOOKSELF_CPT_BOOK;

        add_action("add_meta_boxes_$post_type", [$this, 'addMetaBoxes']);
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

        // 기존의 태그 메타 박스 삭제 처리
        remove_meta_box('tagsdiv-bookself_own', null, 'side');
        remove_meta_box('tagsdiv-bookself_read', null, 'side');

        add_meta_box(
            'bookself-book-stati',
            __('소장 상태', 'bookself'),
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
     * @uses BookSupport::renderMetaBoxProperties
     * @uses BookSupport::renderMetaBoxStati
     */
    public function outputMetaBoxes(WP_Post $post, array $args): void
    {
        if (empty($args['id'])) {
            return;
        }

        switch ($args['id']) {
            case 'bookself-book-properties':
                bookselfCall(BookSupport::class, 'renderMetaBoxProperties', [$post]);
                break;

            case 'bookself-book-stati':
                bookselfCall(BookSupport::class, 'renderMetaBoxStati', [$post]);
                break;
        }
    }
}
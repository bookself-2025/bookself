<?php

namespace Bookself\Bookself\Modules\Admin;

use Bojaghi\Contract\Module;
use Bookself\Bookself\Modules\PostMeta;
use Bookself\Bookself\Objects\Book;
use Bookself\Bookself\Supports\Admin\BookSupport;
use WP_Post;
use WP_Screen;
use function Bookself\Bookself\getTheFirstTerm;

class Edit implements Module
{
    public function __construct()
    {
        $post_type = BOOKSELF_CPT_BOOK;

        add_action('current_screen', [$this, 'currentScreen']);
        add_action("save_post_$post_type", [$this, 'savePost'], 10, 3);
        add_filter('post_updated_messages', [$this, 'updatedMessages']);
    }

    /**
     * @param array $columns
     *
     * @return array
     *
     * @uses RosterList::addColumns()
     */
    public function addColumns(array $columns): array
    {
        if (isset($columns['cb'])) {
            $cb = $columns['cb'];
            unset($columns['cb']);
        } else {
            $cb = null;
        }

        if (isset($columns['date'])) {
            $date = $columns['date'];
            unset($columns['date']);
        } else {
            $date = null;
        }

        return array_merge(
            $cb ? ['cb' => $cb] : [],
            [
                'cover_image' => __('커버 이미지', 'bookself'),
            ],
            $columns,
            [
                'author'       => __('저자', 'bookself'),
                'press_name'   => __('출판사', 'bookself'),
                // 'price'        => __('정가', 'bookself'),
                // 'rate'         => __('평가', 'bookself'),
                // 'release_date' => __('출간일', 'bookself'),
                'own'          => __('보유', 'bookself'),
                'read'         => __('독서', 'bookself'),
            ],
            $date ? ['date' => $date] : [],
        );
    }

    /**
     * @param array $columns
     *
     * @return array
     *
     * @uses RosterList::addSortableColumns()
     */
    public function addSortableColumns(array $columns): array
    {
        return $columns;
    }

    /**
     * @param WP_Screen $screen
     *
     * @return void
     */
    public function currentScreen(WP_Screen $screen): void
    {
        if (BOOKSELF_CPT_BOOK !== $screen->post_type) {
            return;
        }

        if ('edit' === $screen->base) {
            // List
            add_action("manage_{$screen->post_type}_posts_custom_column", [$this, 'outputColumnValues'], 10, 2);
            // add_action('pre_get_posts', [$this, 'preGetPosts']);

            add_filter("manage_{$screen->post_type}_posts_columns", [$this, 'addColumns']);
            add_filter("manage_{$screen->id}_sortable_columns", [$this, 'addSortableColumns']);
        }

        if ('post' === $screen->base) {
            // Single
        }
    }

    /**
     * @param string $column
     * @param int    $postId
     *
     * @return void
     *
     * @uses RosterList::outputColumnValues()
     */
    public function outputColumnValues(string $column, int $postId): void
    {
        $postMeta = bookselfGet(PostMeta::class, true);

        switch ($column) {
            case 'cover_image':
                $url = get_the_post_thumbnail_url($postId, 'thumbnail');
                if ($url) {
                    echo '<img src="' . esc_url($url) . '" alt="cover image" />';
                }
                break;

            case 'author':
                echo esc_html($postMeta->author->get($postId));
                break;

            case 'press_name':
                echo esc_html($postMeta->pressName->get($postId));
                break;

            case 'price':
                echo esc_html(Book::formatPrice($postId));
                break;

            case 'rate':
                echo esc_html($postMeta->rate->get($postId));
                break;

            case 'release_date':
                echo esc_html($postMeta->releaseDate->get($postId));
                break;

            case 'own':
                echo esc_html(getTheFirstTerm($postId, BOOKSELF_TAX_OWN)->name ?? '');
                break;

            case 'read':
                echo esc_html(getTheFirstTerm($postId, BOOKSELF_TAX_READ)->name ?? '');
                break;
        }
    }

    /**
     * @param int     $postId
     * @param WP_Post $post
     * @param bool    $update
     *
     * @return void
     *
     * @uses BookSupport::saveProperties
     */
    public function savePost(int $postId, WP_Post $post, bool $update): void
    {
        if (
            !$update ||
            !$postId ||
            BOOKSELF_CPT_BOOK !== $post->post_type ||
            !wp_verify_nonce($_REQUEST['_bookself_book_properties'] ?? '', 'bookself-book-properties')
        ) {
            return;
        }

        bookselfCall(BookSupport::class, 'saveProperties', [$postId, $_POST]);
    }

    public function updatedMessages(array $messages): array
    {
        global $post_type;

        if (BOOKSELF_CPT_BOOK === $post_type) {
            $messages['post'][1] = __('도서 업데이트 됨.', 'bookself');
            $messages['post'][4] = __('도서 업데이트 됨.', 'bookself');
            $messages['post'][6] = __('도서가 공개되었습니다.', 'bookself');
            $messages['post'][7] = __('도서 저장됨.', 'bookself');
            $messages['post'][8] = __('도서 정보를 제출했습니다.', 'bookself');
        }

        return $messages;
    }
}
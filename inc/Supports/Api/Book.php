<?php

namespace Bookself\Bookself\Supports\Api;

use Bojaghi\Contract\Support;
use Bookself\Bookself\Modules\PostMeta;
use Bookself\Bookself\Objects\BookObject;
use WP_Error;
use WP_Query;

class Book implements Support
{
    /**
     * Add a book
     *
     * @param string|array $args
     *
     * @return BookObject|WP_Error
     */
    public function add(string|array $args = ''): BookObject|WP_Error
    {
        $meta = bookselfGet(PostMeta::class);

        $args = wp_parse_args($args, [
            'user_id'     => 0,
            'author'      => '',
            'coverImage'  => '',
            'isbn'        => '',
            'own'         => '',
            'pressName'   => '',
            'price'       => '',
            'read'        => '',
            'releaseDate' => '',
            'title'       => '',
        ]);

        // Check the sanity of $args
        if (!$args['user_id']) {
            return new WP_Error(400, 'User ID is required.');
        }
        if (!$args['title']) {
            return new WP_Error(400, 'Title is required.');
        }

        if ($args['isbn']) {
            // Check if the user already has the book, search by ISBN code.
            $hasBook = new WP_Query([
                'author'         => $args['user_id'],
                'no_found_rows'  => true,
                'posts_per_page' => 1,
                'meta_query'     => [
                    [
                        'key'   => $meta->isbn->getKey(),
                        'value' => $args['isbn'],
                    ],
                ],
                'post_status'    => 'publish',
                'post_type'      => BOOKSELF_CPT_BOOK,
            ]);
        } else {
            // Check if the user already has the book, search by book title.
            $hasBook = new WP_Query([
                'author'         => $args['user_id'],
                'no_found_rows'  => true,
                'posts_per_page' => 1,
                'post_status'    => 'publish',
                'post_type'      => BOOKSELF_CPT_BOOK,
                'title'          => $args['title'],
            ]);
        }

        if ($hasBook->have_posts()) {
            return new WP_Error(400, 'book-already-registered');
        }

        $book = new BookObject();

        $book->id          = 0;
        $book->userId      = $args['user_id'];
        $book->author      = $args['author'];
        $book->currency    = 'krw';
        $book->isbn        = $args['isbn'];
        $book->own         = $args['own'];
        $book->pressName   = $args['pressName'];
        $book->price       = $args['price'];
        $book->read        = $args['read'];
        $book->releaseDate = $args['releaseDate'];
        $book->title       = $args['title'];

        $book->save();
        $this->addCoverImage($book, $args['coverImage']);

        return $book;
    }

    private function addCoverImage(BookObject $book, string $url): void
    {
        $url = esc_url_raw($url);

        if (!$book->id || !$url) {
            return;
        }

        if (preg_match(';^https?://;', $url)) {
            $r           = wp_remote_get($url);
            $code        = wp_remote_retrieve_response_code($r);
            $contentType = wp_remote_retrieve_header($r, 'Content-Type');
            $body        = wp_remote_retrieve_body($r);
            $dir         = wp_get_upload_dir()['path'];

            if (200 === $code && str_starts_with($contentType, 'image/') && $body) {
                $ext  = substr($contentType, 6);
                $path = sprintf('%s/book-cover-%08d%s', $dir, $book->id, ($ext ? ".$ext" : ''));

                file_put_contents($path, $body);

                $attachId = wp_insert_post(
                    [
                        'post_author'    => $book->userId,
                        'post_title'     => sprintf("'%s' 커버 이미지", $book->title),
                        'post_name'      => 'bookself-cover-image-' . $book->id,
                        'post_parent'    => $book->id,
                        'post_status'    => 'inherit',
                        'post_type'      => 'attachment',
                        'post_mime_type' => $contentType,
                        'file'           => $path,
                    ],
                );

                if (!function_exists('wp_generate_attachment_metadata')) {
                    require_once ABSPATH . 'wp-admin/includes/image.php';
                }
                $metadata = wp_generate_attachment_metadata($attachId, $path);

                update_post_meta($attachId, '_wp_attachment_metadata', $metadata);
                update_post_meta($book->id, '_thumbnail_id', $attachId);
            }
        }
    }

    /**
     * @param string|array $args
     *
     * @return array{items: array, total: int, totalpages: int}
     */
    public function query(string|array $args = ''): array
    {
        $args = wp_parse_args($args, [
            'user_id' => 0,
        ]);

        $result = BookObject::query([
            'author'      => $args['user_id'],
            'order'       => 'desc',
            'orderby'     => 'date',
            'post_status' => 'publish',
        ]);

        return [
            'items'      => $result->items,
            'total'      => $result->total,
            'totalpages' => $result->lastPage,
        ];
    }

    public function get(string|array $args = ''): BookObject|WP_Error
    {
        $args = wp_parse_args($args, [
            'book_id' => 0,
            'user_id' => 0,
        ]);

        $query = new WP_Query([
            'p'                => $args['book_id'],
            'author'           => $args['user_id'],
            'fields'           => 'ids',
            'post_status'      => 'publish',
            'post_type'        => BOOKSELF_CPT_BOOK,
            'posts_per_page'   => 1,
            'suppress_filters' => true,
            'no_found_rows'    => true,
        ]);

        if ($query->have_posts()) {
            return BookObject::get($query->posts[0]);
            // return ObjectBook::get($query->posts[0]);
        }

        return new WP_Error('error', 'Book not found');
    }

    public function update(string|array $args = ''): BookObject|WP_Error
    {
        $args = wp_parse_args($args, [
            'book_id' => 0,
            'user_id' => 0,
        ]);

        $book = $this->get($args);
        if (is_wp_error($book)) {
            return $book;
        }
        if (!current_user_can('administrator') && $book->userId !== $args['user_id']) {
            return new WP_Error('error', 'You cannot change userId of the book object.');
        }

        $props = array_diff(
            array_keys(get_class_vars(BookObject::class)),
            ['id', 'coverImage', 'formattedPrice'],
        );

        foreach ($props as $prop) {
            if (isset($args[$prop])) {
                $book->$prop = $args[$prop];
            }
        }

        $book->save();

        return $book;
    }
}

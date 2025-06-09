<?php

namespace Bookself\Bookself\Supports\Api;

use Bojaghi\Contract\Support;
use Bookself\Bookself\Objects\Book as ObjectBook;
use WP_Error;
use WP_Query;

class Book implements Support
{
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

        $result = ObjectBook::query([
            'author'      => $args['user_id'],
            'order'       => 'desc',
            'orderby'     => 'date',
            'post_status' => 'publish',
            'post_type'   => BOOKSELF_CPT_BOOK,
        ]);

        return [
            'items'      => $result->items,
            'total'      => $result->total,
            'totalpages' => $result->numPages,
        ];
    }

    public function get(string|array $args = ''): ObjectBook|WP_Error
    {
        $args = wp_parse_args($args, [
            'book_id' => 0,
            'user_id' => 0,
        ]);

        $query = new WP_Query([
            'p'                => $args['book_id'],
            'author'           => $args['user_id'],
            'post_status'      => 'publish',
            'post_type'        => BOOKSELF_CPT_BOOK,
            'posts_per_page'   => 1,
            'suppress_filters' => true,
            'no_found_rows'    => true,
        ]);

        if ($query->have_posts()) {
            return ObjectBook::get($query->posts[0]);
        }

        return new WP_Error('error', 'Book not found');
    }

    public function update(string|array $args = ''): ObjectBook|WP_Error
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
            array_keys(get_class_vars(ObjectBook::class)),
            ['id', 'coverImage', 'formattedPrice'],
        );

        foreach ($props as $prop) {
            if (isset($args[$prop])) {
                $book->$prop = $args[$prop];
            }
        }

        $book->update();

        return $book;
    }
}

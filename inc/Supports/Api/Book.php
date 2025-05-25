<?php

namespace Bookself\Bookself\Supports\Api;

use Bojaghi\Contract\Support;
use Bookself\Bookself\Objects\Book as ObjectBook;
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
        $query = new WP_Query(
            [
                'order'       => 'desc',
                'orderby'     => 'date',
                'post_status' => 'publish',
                'post_type'   => BOOKSELF_CPT_BOOK,
            ],
        );

        $items = array_map(fn($post) => ObjectBook::get($post), $query->posts);

        return [
            'items'      => $items,
            'total'      => $query->found_posts,
            'totalpages' => $query->max_num_pages,
        ];
    }
}

<?php

namespace Bookself\Bookself\Supports\Api;

use Bojaghi\Contract\Support;
use WP_Query;
use WP_REST_Request;

class Book implements Support
{
    public function query(WP_REST_Request $request): array
    {
        $query = new WP_Query(
            [
                'order'       => 'desc',
                'orderby'     => 'date',
                'post_status' => 'publish',
                'post_type'   => BOOKSELF_CPT_BOOK,
            ],
        );

        return $query->posts;
    }
}

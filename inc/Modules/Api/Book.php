<?php

namespace Bookself\Bookself\Modules\Api;

use Bojaghi\Contract\Module;
use Bookself\Bookself\Supports\Api\Book as BookSupport;
use WP_REST_Request;
use WP_REST_Response;

class Book implements Module
{
    public function __construct()
    {
        $this->addRoutes();
    }

    private function addRoutes(): void
    {
        register_rest_route(
            'bookself/v1',
            '/books',
            [
                'callback'            => [$this, 'query'],
                'method'              => 'GET',
                'permission_callback' => '__return_true',
                'args'                => [],
            ],
        );
    }

    public function query(WP_REST_Request $request): WP_REST_Response
    {
        $result = bookselfCall(BookSupport::class, 'query');

        return new WP_REST_Response(
            $result['items'],
            200,
            [
                'X-WP-Total'      => $result['total'],
                'X-WP-TotalPages' => $result['totalpages'],
            ],
        );
    }
}

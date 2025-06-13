<?php

namespace Bookself\Bookself\Modules\Api;

use Bojaghi\Contract\Module;
use Bookself\Bookself\Supports\Api\Aladin;
use Bookself\Bookself\Supports\Api\Book as Support;
use Exception;
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
                'callback'            => [$this, 'addOrQuery'],
                'methods'             => ['GET', 'POST'],
                'permission_callback' => 'is_user_logged_in',
                'args'                => [],
            ],
        );

        register_rest_route(
            'bookself/v1',
            '/book/(?P<book_id>\d+)',
            [
                'callback'            => [$this, 'book'],
                'methods'             => ['GET', 'POST'],
                'permission_callback' => 'is_user_logged_in',
                'args'                => [
                    'book_id' => [
                        'required'          => true,
                        'validate_callback' => fn($v) => is_numeric($v),
                        'sanitize_callback' => 'absint',
                    ],
                ],
            ],
        );

        register_rest_route(
            'bookself/v1',
            '/book-info/(?P<isbn>\d{13})/',
            [
                'callback'            => [$this, 'bookInfo'],
                'methods'             => ['GET'],
                'permission_callback' => /*'is_user_logged_in'*/ '__return_true',
                'args'                => [
                    'isbn' => [
                        'required'          => true,
                        'validate_callback' => fn($v) => is_numeric($v),
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
            ],
        );
    }

    public function addOrQuery(WP_REST_Request $request): WP_REST_Response
    {
        if ('GET' === $request->get_method()) {
            $result = bookselfCall(Support::class, 'query', [[
                ...$request->get_params(),
                'user_id' => get_current_user_id(),
            ]]);

            return new WP_REST_Response(
                $result['items'],
                200,
                [
                    'X-WP-Total'      => $result['total'],
                    'X-WP-TotalPages' => $result['totalpages'],
                ],
            );
        }

        if ('POST' === $request->get_method()) {
            $result = bookselfCall(Support::class, 'add', [[
                ...$request->get_params(),
                'user_id' => get_current_user_id(),
            ]]);
            if (is_wp_error($result)) {
                return new WP_REST_Response($result->get_error_message(), $result->get_error_code());
            }
            return new WP_REST_Response($result, 200);
        }

        return new WP_REST_Response('Method not allowed', 405);
    }

    public function book(WP_REST_Request $request): WP_REST_Response
    {
        if ('GET' === $request->get_method()) {
            $result = bookselfCall(Support::class, 'get', [[
                ...$request->get_params(),
                'user_id' => get_current_user_id(),
            ]]);

            if (is_wp_error($result)) {
                return new WP_REST_Response($result->get_error_message(), 400);
            }

            return new WP_REST_Response($result, 200);
        }

        if ('POST' === $request->get_method()) {
            $result = bookselfCall(Support::class, 'update', [[
                ...$request->get_params(),
                'user_id' => get_current_user_id(),
            ]]);

            if (is_wp_error($result)) {
                return new WP_REST_Response($result->get_error_message(), 400);
            }

            return new WP_REST_Response($result, 200);
        }

        return new WP_REST_Response('Method not allowed', 405);
    }

    /**
     * 알라딘 API 이용하여 책 정보 조회
     *
     * @param WP_REST_Request $request
     *
     * @return WP_REST_Response
     *
     * @uses Aladin::getProductInfo()
     */
    public function bookInfo(WP_REST_Request $request): WP_REST_Response
    {
        try {
            $result = bookselfCall(Aladin::class, 'getProductInfo', [$request->get_param('isbn')]);
        } catch (Exception $e) {
            return new WP_REST_Response($e->getMessage(), $e->getCode());
        }

        return new WP_REST_Response($result, 200);
    }
}

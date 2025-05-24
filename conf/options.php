<?php

use function Bookself\Bookself\prefixed;

if (!defined('ABSPATH')) {
    exit;
}

return [
    prefixed('page') => [
        'group'             => BOOKSELF_OPTION_GROUP,
        'type'              => 'integer',
        'label'             => '페이지',
        'description'       => '도서 관리 프론트 페이지 ID',
        'sanitize_callback' => fn(mixed $value): int => absint($value),
        'show_in_rest'      => false,
        'autoload'          => true,
        'default'           => 0,
        'get_filter'        => null,
    ],
];

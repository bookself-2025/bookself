<?php

namespace Bookself\Bookself\Objects;

use WP_Query;

class QueryResult
{
    public array $items;

    public int $total;

    public int $page;

    public int $perPage;

    public int $numPages;

    public function __construct(WP_Query $query)
    {
        $this->items    = array_map(fn($item) => Book::get($item), $query->posts);
        $this->total    = $query->found_posts;
        $this->page     = (int)$query->get('paged');
        $this->perPage  = (int)$query->get('posts_per_page');
        $this->numPages = $query->max_num_pages;
    }
}
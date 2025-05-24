<?php

if (!defined('ABSPATH')) {
    exit;
}

return [
    // bookself_own
    [
        // Taxonomy name. Maximum 32 characters.
        BOOKSELF_TAX_OWN,

        // Object types. Required.
        [BOOKSELF_CPT_BOOK],

        // Arguments.
        [
            'labels'                => [
                'name'                       => _x('소유 상태', 'bookself_own label', 'bookself'),
                // 'singular_name'              => _x('', 'bookself_own label', 'bookself'),
                // 'search_items'               => _x('', 'bookself_own label', 'bookself'),
                // 'popular_items'              => _x('', 'bookself_own label', 'bookself'),
                // 'all_items'                  => _x('', 'bookself_own label', 'bookself'),
                // 'parent_item'                => _x('', 'bookself_own label', 'bookself'),
                // 'parent_item_colon'          => _x('', 'bookself_own label', 'bookself'),
                // 'name_field_description'     => _x('', 'bookself_own label', 'bookself'),
                // 'slug_field_description'     => _x('', 'bookself_own label', 'bookself'),
                // 'parent_field_description'   => _x('', 'bookself_own label', 'bookself'),
                // 'desc_field_description'     => _x('', 'bookself_own label', 'bookself'),
                // 'edit_item'                  => _x('', 'bookself_own label', 'bookself'),
                // 'view_item'                  => _x('', 'bookself_own label', 'bookself'),
                // 'update_item'                => _x('', 'bookself_own label', 'bookself'),
                // 'add_new_item'               => _x('', 'bookself_own label', 'bookself'),
                // 'new_item_name'              => _x('', 'bookself_own label', 'bookself'),
                // 'template_name'              => _x('', 'bookself_own label', 'bookself'),
                // 'separate_items_with_commas' => _x('', 'bookself_own label', 'bookself'),
                // 'add_or_remove_items'        => _x('', 'bookself_own label', 'bookself'),
                // 'choose_from_most_used'      => _x('', 'bookself_own label', 'bookself'),
                // 'not_found'                  => _x('', 'bookself_own label', 'bookself'),
                // 'no_terms'                   => _x('', 'bookself_own label', 'bookself'),
                // 'filter_by_item'             => _x('', 'bookself_own label', 'bookself'),
                // 'items_list_navigation'      => _x('', 'bookself_own label', 'bookself'),
                // 'items_list'                 => _x('', 'bookself_own label', 'bookself'),
                // 'most_used'                  => _x('', 'bookself_own label', 'bookself'),
                // 'back_to_items'              => _x('', 'bookself_own label', 'bookself'),
                // 'item_link'                  => _x('', 'bookself_own label', 'bookself'),
                // 'item_link_description'      => _x('', 'bookself_own label', 'bookself'),
            ],
            'description'           => '개인별 등록된 도서의 소유 상태를 지정',
            'public'                => false,
            'publicly_queryable'    => false,
            'hierarchical'          => false,
            'show_ui'               => false,
            'show_in_menu'          => false,
            'show_in_nav_menus'     => false,
            'show_in_rest'          => false,
            'rest_base'             => 'bookself_own',
            'rest_namespace'        => 'wp/v2',
            'rest_controller_class' => WP_REST_Terms_Controller::class,
            'show_tagcloud'         => false,
            'show_in_quick_edit'    => false,
            'show_admin_column'     => false,
            'meta_box_cb'           => null,
            'meta_box_sanitize_cb'  => null,
            'capabilities'          => [
                'manage_terms' => 'manage_categories',
                'edit_terms'   => 'manage_categories',
                'delete_terms' => 'manage_categories',
                'assign_terms' => 'edit_posts',
            ],
            'rewrite'               => [
                'slug'         => 'bookself_own',
                'with_front'   => true,
                'hierarchical' => false,
                'ep_mask'      => EP_NONE,
            ],
            'query_var'             => 'bookself_own',
            'update_count_callback' => null,
            'default_term'          => [
                'name'        => '소장',
                'slug'        => 'own',
                'description' => '',
            ],
            'sort'                  => false,
            'args'                  => [],
        ],
    ],

    // bookself_read
    [
        // Taxonomy name. Maximum 32 characters.
        BOOKSELF_TAX_READ,

        // Object types. Required.
        [BOOKSELF_CPT_BOOK],

        // Arguments.
        [
            'labels'                => [
                'name'                       => _x('독서 상태', 'bookself_read label', 'bookself'),
                // 'singular_name'              => _x('', 'bookself_read label', 'bookself'),
                // 'search_items'               => _x('', 'bookself_read label', 'bookself'),
                // 'popular_items'              => _x('', 'bookself_read label', 'bookself'),
                // 'all_items'                  => _x('', 'bookself_read label', 'bookself'),
                // 'parent_item'                => _x('', 'bookself_read label', 'bookself'),
                // 'parent_item_colon'          => _x('', 'bookself_read label', 'bookself'),
                // 'name_field_description'     => _x('', 'bookself_read label', 'bookself'),
                // 'slug_field_description'     => _x('', 'bookself_read label', 'bookself'),
                // 'parent_field_description'   => _x('', 'bookself_read label', 'bookself'),
                // 'desc_field_description'     => _x('', 'bookself_read label', 'bookself'),
                // 'edit_item'                  => _x('', 'bookself_read label', 'bookself'),
                // 'view_item'                  => _x('', 'bookself_read label', 'bookself'),
                // 'update_item'                => _x('', 'bookself_read label', 'bookself'),
                // 'add_new_item'               => _x('', 'bookself_read label', 'bookself'),
                // 'new_item_name'              => _x('', 'bookself_read label', 'bookself'),
                // 'template_name'              => _x('', 'bookself_read label', 'bookself'),
                // 'separate_items_with_commas' => _x('', 'bookself_read label', 'bookself'),
                // 'add_or_remove_items'        => _x('', 'bookself_read label', 'bookself'),
                // 'choose_from_most_used'      => _x('', 'bookself_read label', 'bookself'),
                // 'not_found'                  => _x('', 'bookself_read label', 'bookself'),
                // 'no_terms'                   => _x('', 'bookself_read label', 'bookself'),
                // 'filter_by_item'             => _x('', 'bookself_read label', 'bookself'),
                // 'items_list_navigation'      => _x('', 'bookself_read label', 'bookself'),
                // 'items_list'                 => _x('', 'bookself_read label', 'bookself'),
                // 'most_used'                  => _x('', 'bookself_read label', 'bookself'),
                // 'back_to_items'              => _x('', 'bookself_read label', 'bookself'),
                // 'item_link'                  => _x('', 'bookself_read label', 'bookself'),
                // 'item_link_description'      => _x('', 'bookself_read label', 'bookself'),
            ],
            'description'           => '개인별 등록된 도서의 독서 상태를 지정',
            'public'                => false,
            'publicly_queryable'    => false,
            'hierarchical'          => false,
            'show_ui'               => false,
            'show_in_menu'          => false,
            'show_in_nav_menus'     => false,
            'show_in_rest'          => false,
            'rest_base'             => 'bookself_read',
            'rest_namespace'        => 'wp/v2',
            'rest_controller_class' => WP_REST_Terms_Controller::class,
            'show_tagcloud'         => false,
            'show_in_quick_edit'    => false,
            'show_admin_column'     => false,
            'meta_box_cb'           => null,
            'meta_box_sanitize_cb'  => null,
            'capabilities'          => [
                'manage_terms' => 'manage_categories',
                'edit_terms'   => 'manage_categories',
                'delete_terms' => 'manage_categories',
                'assign_terms' => 'edit_posts',
            ],
            'rewrite'               => [
                'slug'         => 'bookself_read',
                'with_front'   => true,
                'hierarchical' => false,
                'ep_mask'      => EP_NONE,
            ],
            'query_var'             => 'bookself_read',
            'update_count_callback' => null,
            'default_term'          => [
                'name'        => '읽기 전',
                'slug'        => 'not-read',
                'description' => '',
            ],
            'sort'                  => false,
            'args'                  => [],
        ],
    ],
];


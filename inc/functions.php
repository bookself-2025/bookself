<?php

namespace Bookself\Bookself {

    use WP_Term;

    function prefixed(string $input): string
    {
        if (isPrefixed($input)) {
            return $input;
        }

        return "bookself_$input";
    }

    function unprefixed(string $input): string
    {
        if (!isPrefixed($input)) {
            return $input;
        }

        return substr($input, strlen('bookself_'));
    }

    function isPrefixed(string $input): bool
    {
        return str_starts_with($input, 'bookself_');
    }

    function getTheFirstTerm(int $postId, string $taxonomy): ?WP_Term
    {
        $terms = wp_get_post_terms($postId, $taxonomy);

        return is_array($terms) && $terms && $terms[0] instanceof WP_Term ? $terms[0] : null;
    }

    function getAllTerms(string $taxonomy): array
    {
        $all   = [];
        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);;

        if (is_array($terms)) {
            foreach ($terms as $t) {
                $all[$t->slug] = $t->name;
            }
        }

        return $all;
    }
}

namespace Bookself\Bookself\Kses {

    function getAllowedHtml(): array
    {
        static $allowed = null;

        if (is_null($allowed)) {
            $defaultAttrs = [
                'id'    => true,
                'class' => true,
                'style' => true,
            ];

            $allowed = [
                'a'        => [
                    ...$defaultAttrs,
                    'href'    => true,
                    'onclick' => true,
                    'target'  => true,
                    'title'   => true,
                ],
                'button'   => [
                    ...$defaultAttrs,
                    'disabled' => true,
                    'onClick'  => true,
                ],
                'div'      => [
                    ...$defaultAttrs,
                ],
                'dd'       => [
                    ...$defaultAttrs,
                ],
                'dl'       => [
                    ...$defaultAttrs,
                ],
                'dt'       => [
                    ...$defaultAttrs,
                ],
                'form'     => [
                    ...$defaultAttrs,
                    'action'  => true,
                    'method'  => true,
                    'name'    => true,
                    'enctype' => true,
                ],
                'h1'       => [
                    ...$defaultAttrs,
                ],
                'h2'       => [
                    ...$defaultAttrs,
                ],
                'h3'       => [
                    ...$defaultAttrs,
                ],
                'h4'       => [
                    ...$defaultAttrs,
                ],
                'h5'       => [
                    ...$defaultAttrs,
                ],
                'img'      => [
                    ...$defaultAttrs,
                    'data-src' => true,
                    'alt'      => true,
                    'height'   => true,
                    'src'      => true,
                    'title'    => true,
                    'width'    => true,
                ],
                'input'    => [
                    ...$defaultAttrs,
                    'checked'  => true,
                    'disabled' => true,
                    'min'      => true,
                    'max'      => true,
                    'name'     => true,
                    'readonly' => true,
                    'required' => true,
                    'type'     => true,
                    'value'    => true,
                ],
                'label'    => [
                    ...$defaultAttrs,
                    'for' => true,
                ],
                'option'   => [
                    ...$defaultAttrs,
                    'checked'  => true,
                    'disabled' => true,
                    'selected' => true,
                    'value'    => true,
                ],
                'select'   => [
                    ...$defaultAttrs,
                    'disabled' => true,
                    'name'     => true,
                ],
                'span'     => [
                    ...$defaultAttrs,
                ],
                'table'    => [
                    ...$defaultAttrs,
                    'role' => true,
                ],
                'tbody'    => [
                    ...$defaultAttrs,
                ],
                'textarea' => [
                    ...$defaultAttrs,
                    'disabled' => true,
                    'name'     => true,
                    'cols'     => true,
                    'readonly' => true,
                    'required' => true,
                    'rows'     => true,
                ],
                'tr'       => [
                    ...$defaultAttrs,
                ],
                'th'       => [
                    ...$defaultAttrs,
                    'scope' => true,
                ],
                'td'       => [
                    ...$defaultAttrs,
                ],
                'ul'       => [
                    ...$defaultAttrs,
                ],
                'li'       => [
                    ...$defaultAttrs,
                ],
                'p'        => [
                    ...$defaultAttrs,
                ],
            ];
        }

        return $allowed;
    }
}

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

    /**
     * 모든 읽은 상태 텀 리턴
     *
     * 플랫한 택소노미라서 슬러그/이름 쌍 형태의 배열을 리턴한다.
     *
     * @return array<string, string>
     */
    function getAllReadTerms(): array
    {
        return getAllTerms(BOOKSELF_TAX_READ);
    }

    /**
     * 모든 도서 소유 상태 텀 리턴
     *
     * 위계적 택소노미라서 약간의 트릭을 쓴다. 배열은 텀ID/이름 쌍 형태이다.
     *
     * @return array<int, string>
     */
    function getAllOwnTerms(string $field = 'name'): array
    {
        $output = getAllTerms(BOOKSELF_TAX_OWN, 'own', $field);

        $notOwn = get_term_by('slug', 'not-own', BOOKSELF_TAX_OWN);
        if ($notOwn) {
            $output[$notOwn->term_id] = $notOwn->$field;
        }

        return $output;
    }

    function getAllTerms(string $taxonomy, string $parentOf = '', string $field = 'name'): array
    {
        $all = [];

        if (is_taxonomy_hierarchical($taxonomy)) {
            $t = get_term_by('slug', $parentOf, $taxonomy);
            if ($t) {
                $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false, 'parent' => $t->term_id]);
                if (is_array($terms)) {
                    foreach ($terms as $t) {
                        $all[$t->term_id] = $t->$field;
                    }
                }
            }
        } else {
            $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);;
            if (is_array($terms)) {
                foreach ($terms as $t) {
                    $all[$t->slug] = $t->$field;
                }
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

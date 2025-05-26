<?php

namespace Bookself\Bookself\Supports\Admin;

use Bojaghi\Contract\Support;
use Bojaghi\Template\Template;
use Bookself\Bookself\Modules\PostMeta;
use WP_Post;
use function Bookself\Bookself\getAllTerms;
use function Bookself\Bookself\getTheFirstTerm;
use function Bookself\Bookself\Kses\getAllowedHtml;

readonly class BookSupport implements Support
{
    public function __construct(
        private PostMeta $postMeta,
        private Template $template,
    )
    {
    }

    public function renderMetaBoxProperties(WP_Post $post): void
    {
        $field = [
            'author'       => $this->postMeta->author->getKey(),
            'currency'     => $this->postMeta->currency->getKey(),
            'isbn'         => $this->postMeta->isbn->getKey(),
            'press_name'   => $this->postMeta->pressName->getKey(),
            'price'        => $this->postMeta->price->getKey(),
            'rate'         => $this->postMeta->rate->getKey(),
            'release_date' => $this->postMeta->releaseDate->getKey(),
        ];

        $value = [
            'author'       => $this->postMeta->author->get($post),
            'currency'     => $this->postMeta->currency->get($post),
            'isbn'         => $this->postMeta->isbn->get($post),
            'press_name'   => $this->postMeta->pressName->get($post),
            'price'        => $this->postMeta->price->get($post),
            'rate'         => $this->postMeta->rate->get($post),
            'release_date' => $this->postMeta->releaseDate->get($post),
        ];

        echo wp_kses(
            $this->template->template('admin/meta-box-book-properties', [
                'field' => $field,
                'value' => $value,
            ]),
            getAllowedHtml(),
        );
    }

    public function renderMetaBoxStati(WP_Post $post): void
    {
        echo wp_kses(
            $this->template->template('admin/meta-box-book-stati', [
                'field'   => [
                    'own'  => BOOKSELF_TAX_OWN,
                    'read' => BOOKSELF_TAX_READ,
                ],
                'value'   => [
                    'own'  => getTheFirstTerm($post->ID, BOOKSELF_TAX_OWN)->slug ?? '',
                    'read' => getTheFirstTerm($post->ID, BOOKSELF_TAX_READ)->slug ?? '',
                ],
                'options' => [
                    'own'  => getAllTerms(BOOKSELF_TAX_OWN),
                    'read' => getAllTerms(BOOKSELF_TAX_READ),
                ],
            ]),
            getAllowedHtml(),
        );
    }

    public function save(int $postId, array $data): void
    {
        $keys = [
            $this->postMeta->author->getKey(),
            $this->postMeta->currency->getKey(),
            $this->postMeta->isbn->getKey(),
            $this->postMeta->pressName->getKey(),
            $this->postMeta->price->getKey(),
            $this->postMeta->rate->getKey(),
            $this->postMeta->releaseDate->getKey(),
        ];

        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $this->postMeta->{$key}->update($postId, $data[$key]);
            }
        }

        foreach ([BOOKSELF_TAX_OWN, BOOKSELF_TAX_READ] as $taxonomy) {
            if (isset($data[$taxonomy])) {
                wp_set_post_terms($postId, $data[$taxonomy], $taxonomy);
            }
        }
    }
}

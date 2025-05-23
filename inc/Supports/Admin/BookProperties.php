<?php

namespace Bookself\Bookself\Supports\Admin;

use Bojaghi\Contract\Support;
use Bojaghi\Template\Template;
use Bookself\Bookself\Modules\PostMeta;
use WP_Post;
use function Bookself\Bookself\Kses\getAllowedHtml;

readonly class BookProperties implements Support
{
    public function __construct(
        private PostMeta $postMeta,
        private Template $template,
    )
    {
    }

    public function renderMetaBox(WP_Post $post): void
    {
        $field = [
            'author'       => $this->postMeta->author->getKey(),
            'currency'     => $this->postMeta->currency->getKey(),
            'isbn'         => $this->postMeta->isbn->getKey(),
            'press_name'   => $this->postMeta->pressName->getKey(),
            'price'        => $this->postMeta->price->getKey(),
            'release_date' => $this->postMeta->releaseDate->getKey(),
        ];

        $value = [
            'author'       => $this->postMeta->author->get($post),
            'currency'     => $this->postMeta->currency->get($post),
            'isbn'         => $this->postMeta->isbn->get($post),
            'press_name'   => $this->postMeta->pressName->get($post),
            'price'        => $this->postMeta->price->get($post),
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

    public function saveProperties(int $postId, array $data): void
    {
        $keys = [
            $this->postMeta->author->getKey(),
            $this->postMeta->currency->getKey(),
            $this->postMeta->isbn->getKey(),
            $this->postMeta->pressName->getKey(),
            $this->postMeta->price->getKey(),
            $this->postMeta->releaseDate->getKey(),
        ];

        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $this->postMeta->{$key}->update($postId, $data[$key]);
            }
        }
    }
}

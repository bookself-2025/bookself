<?php

namespace Bookself\Bookself\Objects;

use Bookself\Bookself\Modules\PostMeta;
use NumberFormatter;
use WP_Post;
use WP_Query;
use function Bookself\Bookself\getTheFirstTerm;

class Book
{
    /** @var int 워드프레스 포스트 ID */
    public int    $id          = 0;
    public int    $userId      = 0;
    public string $author      = '';
    public string $currency    = '';
    public string $isbn        = '';
    public string $own         = '';
    public string $pressName   = '';
    public string $price       = '';
    public int    $rate        = 0;
    public string $read        = '';
    public string $releaseDate = '';
    public int    $thumbnailId = 0;
    public string $title       = '';

    // 편의를 위해 생성.
    public array  $coverImage     = [];
    public string $formattedPrice = '';

    public function delete(bool $force = false): void
    {
        wp_delete_post($this->id, $force);
    }

    public static function get(WP_Post|string|int $id): self
    {
        $meta   = bookselfGet(PostMeta::class);
        $post   = get_post($id);
        $output = new self();

        if ($post && BOOKSELF_CPT_BOOK === $post->post_type) {
            $output->id          = $post->ID;
            $output->author      = $meta->author->get($post->ID);
            $output->currency    = $meta->currency->get($post->ID);
            $output->isbn        = $meta->isbn->get($post->ID);
            $output->own         = getTheFirstTerm($post->ID, BOOKSELF_TAX_OWN)->slug ?? '';
            $output->pressName   = $meta->pressName->get($post->ID);
            $output->price       = $meta->price->get($post->ID);
            $output->rate        = $meta->rate->get($post->ID);
            $output->read        = getTheFirstTerm($post->ID, BOOKSELF_TAX_READ)->slug ?? '';
            $output->releaseDate = $meta->releaseDate->get($post->ID);
            $output->thumbnailId = get_post_thumbnail_id($post->ID) ?: 0;
            $output->title       = $post->post_title;

            $output->coverImage     = Book::formatCoverImage($post);
            $output->formattedPrice = Book::formatPrice($post);
        }

        return $output;
    }

    public static function formatCoverImage(WP_Post|int $post): array
    {
        $output = [];
        $post   = get_post($post);

        if ($post && BOOKSELF_CPT_BOOK === $post->post_type && has_post_thumbnail($post)) {
            $thumbId  = get_post_thumbnail_id($post);
            $metadata = wp_get_attachment_metadata($thumbId, true);
            $baseurl  = wp_get_upload_dir()['baseurl'];

            $output = [
                'full' => [
                    'url'    => path_join($baseurl, $metadata['file']),
                    'width'  => $metadata['width'],
                    'height' => $metadata['height'],
                ],
            ];

            foreach ($metadata['sizes'] as $size => $data) {
                $output[$size] = [
                    'url'    => path_join($baseurl, $data['file']),
                    'width'  => $data['width'],
                    'height' => $data['height'],
                ];
            }
        }

        return $output;
    }

    public static function formatPrice(WP_Post|int $post): string
    {
        $output = '';
        $post   = get_post($post);
        $meta   = bookselfGet(PostMeta::class);

        if ($post && BOOKSELF_CPT_BOOK === $post->post_type) {
            $currency = $meta->currency->get($post);
            $price    = $meta->price->get($post);

            if ($currency && $price) {
                $locale = match ($currency) {
                    'eur'   => 'de_DE',
                    'jpy'   => 'ja_JP',
                    'usd'   => 'en_US',
                    default => 'ko_KR',
                };

                $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
                $output    = $formatter->format($price);
            }
        }

        return $output;
    }

    public static function query(string|array $args = ''): QueryResult
    {
        return new QueryResult(new WP_Query($args));
    }

    public function update(): void
    {
        $meta = bookselfGet(PostMeta::class);

        $data = [
            'ID'          => $this->id,
            'post_title'  => $this->title,
            'post_type'   => BOOKSELF_CPT_BOOK,
            'post_status' => 'publish',
            'meta_input'  => [
                $meta->author->getKey()      => $this->author,
                $meta->currency->getKey()    => $this->currency,
                $meta->isbn->getKey()        => $this->isbn,
                $meta->pressName->getKey()   => $this->pressName,
                $meta->price->getKey()       => $this->price,
                $meta->rate->getKey()        => $this->rate,
                $meta->releaseDate->getKey() => $this->releaseDate,
                '_thumbnail_id'              => $this->thumbnailId,
            ],
        ];

        if ($this->id) {
            $newId = wp_update_post($data);
        } else {
            unset($data['ID']);
            $newId    = wp_insert_post($data);
            $this->id = $newId;
        }

        if (is_wp_error($newId)) {
            wp_die($newId);
        }

        if ($this->own) {
            wp_set_post_terms($this->id, $this->own, BOOKSELF_TAX_OWN);
        }

        if ($this->read) {
            wp_set_post_terms($this->id, $this->read, BOOKSELF_TAX_READ);
        }
    }
}

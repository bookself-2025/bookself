<?php

namespace Bookself\Bookself\Objects;

use Bookself\Bookself\Modules\PostMeta;
use NumberFormatter;
use WP_Post;
use function Bookself\Bookself\getTheFirstTerm;

class Book
{
    /** @var int 워드프레스 포스트 ID */
    public int    $id          = 0;
    public string $author      = '';
    public array  $coverImage  = [];
    public int    $rate        = 0;
    public string $isbn        = '';
    public string $own         = '';
    public string $pressName   = '';
    public string $price       = '';
    public string $read        = '';
    public string $releaseDate = '';
    public string $title       = '';

    public static function get(WP_Post|string|int $id): self
    {
        $meta   = bookselfGet(PostMeta::class);
        $post   = get_post($id);
        $output = new self();

        if ($post && BOOKSELF_CPT_BOOK === $post->post_type) {
            $output->id          = $post->ID;
            $output->author      = $meta->author->get($post->ID);
            $output->coverImage  = Book::formatCoverImage($post);
            $output->own         = getTheFirstTerm($post->ID, BOOKSELF_TAX_OWN)->slug ?? '';
            $output->rate        = $meta->rate->get($post->ID);
            $output->read        = getTheFirstTerm($post->ID, BOOKSELF_TAX_READ)->slug ?? '';
            $output->isbn        = $meta->isbn->get($post->ID);
            $output->pressName   = $meta->pressName->get($post->ID);
            $output->price       = Book::formatPrice($post);
            $output->releaseDate = $meta->releaseDate->get($post->ID);
            $output->title       = $post->post_title;
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
}

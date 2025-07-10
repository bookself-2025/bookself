<?php

namespace Bookself\Bookself\Objects;

use Bojaghi\BaseObject\Attributes\Field\Post;
use Bojaghi\BaseObject\Attributes\Field\PostMeta;
use Bojaghi\BaseObject\Attributes\Field\PostTerm;
use Bojaghi\BaseObject\Attributes\Origin\PostOrigin;
use Bojaghi\BaseObject\Attributes\Primary;
use Bojaghi\BaseObject\BaseObject;
use Bojaghi\BaseObject\QueryResult;
use NumberFormatter;
use WP_Post;

#[PostOrigin(post_type: BOOKSELF_CPT_BOOK)]
class BookObject extends BaseObject
{
    #[Primary]
    #[Post('ID')]
    public int $id = 0;

    #[Post('post_author')]
    public int $userId = 0;

    #[PostMeta('bookself_author', true)]
    public string $author = '';

    #[PostMeta('bookself_currency', true)]
    public string $currency = '';

    #[PostMeta('bookself_isbn', true)]
    public string $isbn = '';

    #[PostTerm(BOOKSELF_TAX_OWN, true, 'term_id')]
    public string $own = '';

    #[PostMeta('bookself_press_name', true)]
    public string $pressName = '';

    #[PostMeta('bookself_price', true)]
    public string $price = '';

    #[PostMeta('bookself_rate', true)]
    public int $rate = 0;

    #[PostTerm(BOOKSELF_TAX_READ, true, 'slug')]
    public string $read = '';

    #[PostMeta('bookself_release_date', true)]
    public string $releaseDate = '';

    #[PostMeta('_thumbnail_id', true)]
    public int $thumbnailId = 0;

    #[Post('post_title')]
    public string $title = '';

    // 편의를 위해 생성.
    public array  $coverImage     = [];
    public string $formattedPrice = '';

    public static function formatCoverImage(WP_Post|int $post): array
    {
        $output = [];
        $post   = get_post($post);

        if ($post && BOOKSELF_CPT_BOOK === $post->post_type && has_post_thumbnail($post)) {
            $thumbId  = get_post_thumbnail_id($post);
            $metadata = wp_get_attachment_metadata($thumbId, true);
            $baseurl  = wp_get_upload_dir()['baseurl'];
            $fullUrl  = path_join($baseurl, $metadata['file']);

            $output = [
                'full' => [
                    'url'    => $fullUrl,
                    'width'  => $metadata['width'],
                    'height' => $metadata['height'],
                ],
            ];

            if (isset($metadata['sizes'])) {
                foreach ($metadata['sizes'] as $size => $data) {
                    $output[$size] = [
                        'url'    => path_join(dirname($fullUrl), $data['file']),
                        'width'  => $data['width'],
                        'height' => $data['height'],
                    ];
                }
            }
        }

        return $output;
    }

    public static function formatPrice(WP_Post|int $post): string
    {
        $output = '';
        $post   = get_post($post);
        $meta   = bookselfGet(\Bookself\Bookself\Modules\PostMeta::class);

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

    public static function query(string|array $args = []): QueryResult
    {
        $result = parent::query($args);

        foreach ($result->items as &$item) {
            $item['coverImage']     = BookObject::formatCoverImage($item['id']);
            $item['formattedPrice'] = BookObject::formatPrice($item['id']);
        }

        return $result;
    }
}

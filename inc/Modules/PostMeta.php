<?php

namespace Bookself\Bookself\Modules;

use Bojaghi\Fields\Meta\Meta;
use Bojaghi\Fields\Modules\CustomFields as CustomFieldsBase;
use function Bookself\Bookself\prefixed;

/**
 * @property-read Meta $author
 * @property-read Meta $currency
 * @property-read Meta $isbn
 * @property-read Meta $pressName
 * @property-read Meta $price
 * @property-read Meta $rate
 * @property-read Meta $releaseDate
 */
class PostMeta extends CustomFieldsBase
{
    public function __get(string $name)
    {
        $mapped = match ($name) {
            'author'      => prefixed('author'),
            'currency'    => prefixed('currency'),
            'isbn'        => prefixed('isbn'),
            'pressName'   => prefixed('press_name'),
            'price'       => prefixed('price'),
            'rate'        => prefixed('rate'),
            'releaseDate' => prefixed('release_date'),
            default       => '',
        };

        if ($mapped) {
            return $this->getPostMeta($mapped);
        } else {
            return $this->getPostMeta($name);
        }
    }
}

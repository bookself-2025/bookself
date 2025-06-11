<?php

namespace Bookself\Bookself\Modules;

use Bojaghi\Fields\Modules\Options as OptionsBase;
use Bojaghi\Fields\Option\Option;

use function Bookself\Bookself\prefixed;

/**
 * @property-read Option $page
 * @property-read Option $ttbKey
 */
class Options extends OptionsBase
{
    public function __get(string $name)
    {
        $mapped = match ($name) {
            'page'   => prefixed('page'),
            'ttbKey' => prefixed('aladin_ttb_key'),
            default  => '',
        };

        if ($mapped) {
            return $this->getOption($mapped);
        }

        return null;
    }
}

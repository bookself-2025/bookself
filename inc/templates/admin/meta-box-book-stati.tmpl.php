<?php

use Bojaghi\FieldsRender\AdminCompound as AC;
use Bojaghi\Template\Template;

/**
 * Template: 책 속성 메타 박스
 *
 * @var Template $this
 */
?>

<div class="bookself-form-fields bookself-book-stati">
    <dl>
        <dt>
            <label for="bookself-tax-own"><?php esc_html_e('보유', 'bookself'); ?></label>
        </dt>
        <dd>
            <?php
            echo AC::choice(
                choices: $this->get('options')['own'],
                value: $this->get('value')['own'],
                style: 'radio',
                attrs: [
                    'id'   => $this->get('field')['own'],
                    'name' => $this->get('field')['own'],
                ],
            );
            ?>
        </dd>

        <dt>
            <label for="bookself-tax-read"><?php esc_html_e('독서', 'bookself'); ?></label>
        </dt>
        <dd>
            <?php
            echo AC::choice(
                choices: $this->get('options')['read'],
                value: $this->get('value')['read'],
                style: 'radio',
                attrs: [
                    'id'   => $this->get('field')['read'],
                    'name' => $this->get('field')['read'],
                ],
            );
            ?>
        </dd>
    </dl>
</div>


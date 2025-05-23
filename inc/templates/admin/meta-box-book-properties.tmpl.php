<?php

use Bojaghi\Template\Template;

/**
 * Template: 책 속성 메타 박스
 *
 * @var Template $this
 */
?>

    <div class="bookself-form-fields bookself-book-properties">
        <dl>
            <dt>
                <label for="bookself-book-isbn"><?php esc_html_e('ISBN', 'bookself'); ?></label>
            </dt>
            <dd>
                <input
                    id="bookself-book-isbn"
                    class="text"
                    name="<?php echo esc_attr($this->get('field')['isbn'] ?? ''); ?>"
                    type="text"
                    value="<?php echo esc_attr($this->get('value')['isbn'] ?? ''); ?>"
                />
            </dd>

            <dt>
                <label for="bookself-book-press_name"><?php esc_html_e('출판사', 'bookself'); ?></label>
            </dt>
            <dd>
                <input
                    id="bookself-book-press_name"
                    class="type"
                    name="<?php echo esc_attr($this->get('field')['press_name'] ?? ''); ?>"
                    type="text"
                    value="<?php echo esc_attr($this->get('value')['press_name'] ?? ''); ?>"
                />
            </dd>

            <dt>
                <label for="bookself-book-release_date"><?php esc_html_e('출간일', 'bookself'); ?></label>
            </dt>
            <dd>
                <input
                    id="bookself-book-release_date"
                    class="type"
                    name="<?php echo esc_attr($this->get('field')['release_date'] ?? ''); ?>"
                    type="date"
                    value="<?php echo esc_attr($this->get('value')['release_date'] ?? ''); ?>"
                />
            </dd>

            <dt>
                <label for="bookself-book-author"><?php esc_html_e('저자', 'bookself'); ?></label>
            </dt>
            <dd>
                <input
                    id="bookself-book-author"
                    class="type"
                    name="<?php echo esc_attr($this->get('field')['author'] ?? ''); ?>"
                    type="text"
                    value="<?php echo esc_attr($this->get('value')['author'] ?? ''); ?>"
                />
            </dd>

            <dt>
                <label for="bookself-book-price"><?php esc_html_e('정가', 'bookself'); ?></label>
            </dt>
            <dd class="currency-field">
                <label
                    for="bookself-book-currency"
                    class="currency-label screen-reader-text"
                ><?php esc_html_e('통화', 'bookself'); ?></label>
                <select
                    id="bookself-book-currency"
                    name="<?php echo esc_attr($this->get('field')['currency'] ?? ''); ?>"
                >
                    <option disabled>통화</option>
                    <?php foreach (['krw' => '₩', 'usd' => '$', 'jpy' => '¥', 'eur' => '€'] as $currency => $sign): ?>
                        <option
                            value="<?php echo esc_attr($currency); ?>"
                            <?php checked($currency === ($this->get('value')['currency'] ?? '')); ?>
                        ><?php echo esc_html($sign); ?></option>
                    <?php endforeach; ?>
                </select>
                <input
                    id="bookself-book-price"
                    class="type"
                    name="<?php echo esc_attr($this->get('field')['price'] ?? ''); ?>"
                    type="text"
                    value="<?php echo esc_attr($this->get('value')['price'] ?? ''); ?>"
                />
            </dd>
        </dl>
    </div>
<?php
wp_nonce_field('bookself-book-properties', '_bookself_book_properties', false);

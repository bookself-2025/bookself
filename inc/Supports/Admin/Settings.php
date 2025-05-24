<?php

namespace Bookself\Bookself\Supports\Admin;

use Bojaghi\Contract\Support;
use Bojaghi\FieldsRender\AdminCompound as AC;
use Bojaghi\Template\Template;
use Bookself\Bookself\Modules\Options;
use function Bookself\Bookself\Kses\getAllowedHtml;

class Settings implements Support
{
    public function __construct()
    {
    }

    public function render(Template $template): void
    {
        $this->prepareSettings();

        $output = $template->template(
            'admin/settings',
            [
                'option_group' => BOOKSELF_OPTION_GROUP,
                'page_slug'    => BOOKSELF_SETTINGS_PAGE,
                'page_title'   => __('북셀프 설정', 'bookself'),
            ],
        );

        echo wp_kses($output, getAllowedHtml());
    }

    private function prepareSettings(): void
    {
        $option  = bookselfGet(Options::class);
        $page    = BOOKSELF_SETTINGS_PAGE;
        $section = 'bookself-settings-page';

        add_settings_section(
            $section,
            __('페이지', 'bookself'),
            '__return_empty_string',
            $page,
        );

        add_settings_field(
            "$section-front",
            __('프론트 페이지', 'bookself'),
            [$this, 'outputPageField'],
            $page,
            $section,
            [
                'desc'      => __('사용할 페이지를 선택하세요. 선택한 페이지의 내용은 무시되고 회원명부가 출력됩니다.', 'bookself'),
                'label_for' => "$section-front",
                'name'      => $option->page->getKey(),
                'value'     => $option->page->get(),
            ],
        );
    }

    /**
     * Output page field
     *
     * @param array $args
     *
     * @return void
     */
    public function outputPageField(array $args): void
    {
        $desc     = $args['desc'] ?? '';
        $labelFor = $args['label_for'] ?? '';
        $name     = $args['name'] ?? '';
        $value    = $args['value'] ?? '';

        wp_dropdown_pages(
            [
                'id'               => $labelFor,
                'show_option_none' => __('사용할 페이지 선택', 'bookself'),
                'name'             => $name,
                'selected'         => $value,
            ],
        );

        echo wp_kses(AC::description($desc), getAllowedHtml());
    }
}

<?php

namespace Bookself\Bookself\Supports;

use Bojaghi\Contract\Support;
use Bojaghi\ViteScripts\MountNode;
use Bojaghi\ViteScripts\ViteScript;
use Bookself\Bookself\Modules\Options;

readonly class FrontPage implements Support
{
    public function __construct()
    {
    }

    /**
     * Add extra attributes to <html> tag
     *
     * @param string $output
     *
     * @return string
     */
    public function addExtraAttrsToHTML(string $output): string
    {
        return $output . ' data-theme="nord"';
    }

    /**
     * Check before the clean page template
     *
     * @return void
     *
     * @see conf/clean-pages.php
     */
    public function before(): void
    {
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url(get_the_permalink()));
            exit;
        }

        add_action('bojaghi/clean-pages/head/end', [$this, 'outputExtraHead']);
        add_filter('language_attributes', [$this, 'addExtraAttrsToHTML'], 10, 2);
        add_filter('bojaghi/clean-pages/head/meta/viewport', fn() => 'width=device-width, initial-scale=1, viewport-fit=cover', 10, 2);
    }

    public function checkCondition(Options $options): bool
    {
        $page = $options->page->get();

        return $page && is_page($page);
    }

    /**
     * Add some more child tags to <head>
     *
     * @return void
     */
    public function outputExtraHead(): void
    {
        // TODO: output site icons

        echo '<title>' . __('Bookself 2025', 'bookself') . "</title>\n";
    }

    /**
     * @return void
     */
    public function render(): void
    {
        MountNode::render(
            [
                'id'            => 'bookself-root',
                'class'         => 'bookself',
                'inner_content' => 'Bookself is ready',
            ],
        );

        $user = wp_get_current_user();

        bookselfGet(ViteScript::class)
            ?->add('bookself', 'src/v1/app.tsx')
            ->vars('bookselfVars', [
                'api' => [
                    'baseUrl' => home_url('/wp-json/bookself/v1'),
                    'nonce'   => wp_create_nonce('wp_rest'),
                ],
            ])
        ;
    }
}

<?php

namespace Bookself\Bookself\Supports;

use Bojaghi\Contract\Support;
use Bojaghi\ViteScripts\MountNode;
use Bojaghi\ViteScripts\ViteScript;

readonly class FrontPage implements Support
{
    public function __construct(
        private ViteScript $vite,
    )
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
        return $output . ' data-theme="light"';
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

        // add_action('wp_before_admin_bar_render', function () {
        //     remove_action('wp_before_admin_bar_render', 'wp_customize_support_script');
        // }, 5);
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

        $this->vite
            ->add('bookself', 'src/v1/app.tsx')
            ->vars('bookselfVars', [])
        ;
    }
}

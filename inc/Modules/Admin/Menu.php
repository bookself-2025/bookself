<?php

namespace Bookself\Bookself\Modules\Admin;

use Bojaghi\Contract\Module;
use Bookself\Bookself\Supports\Admin\Settings;

class Menu implements Module
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addAdminMenu']);
    }

    public function addAdminMenu(): void
    {
        add_options_page(
            '북셀프 설정 페이지',
            '북셀프 설정',
            'manage_options',
            BOOKSELF_SETTINGS_PAGE,
            fn() => bookselfCall(Settings::class, 'render'),
        );
    }
}
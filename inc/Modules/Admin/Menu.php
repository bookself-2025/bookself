<?php

namespace Bookself\Bookself\Modules\Admin;

use Bojaghi\Contract\Module;
use Bookself\Bookself\Supports\Admin\Settings;

class Menu implements Module
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_menu', [$this, 'removeBuiltinMenus'], 9999);
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

    public function removeBuiltinMenus(): void
    {
        // remove_menu_page('edit.php');
        // remove_menu_page('edit-comments.php');
    }
}
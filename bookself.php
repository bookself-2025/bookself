<?php
/**
 * Plugin Name: Bookself 2025
 * Plugin URI: https://github.com/bookself-2025/bookself
 * Description: 사이드 프로젝트. 워드프레스를 위한 개인 도서 관리 플러그인.
 * Author: nononi, changwoo
 * Author URI:
 * Version: 0.1.0
 * Requires PHP: 8.2
 * Requires at least: 6.5
 */

use Bojaghi\Continy\ContinyException;

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

const BOOKSELF_MAIN    = __FILE__;
const BOOKSELF_VERSION = '0.1.0';

try {
    bookself();
} catch (ContinyException $e) {
    wp_die($e->getMessage());
}

<?php
namespace Yellowstep\ElementorEditor;
use Yellowstep\ElementorEditor\Rest\Routes;
use Yellowstep\ElementorEditor\Rest\AdminPage;
if (!defined('ABSPATH')) { exit; }
final class Plugin {
    public static function boot(): void {
        add_action('rest_api_init', [Routes::class, 'register']);
        add_action('admin_menu', [AdminPage::class, 'register']);
    }
}

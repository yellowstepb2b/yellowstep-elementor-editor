<?php
namespace Yellowstep\ElementorEditor;
use Yellowstep\ElementorEditor\Rest\Routes;
use Yellowstep\ElementorEditor\Rest\AdminPage;
use Yellowstep\ElementorEditor\Abilities\Registrar;
if (!defined('ABSPATH')) { exit; }
final class Plugin {
    public static function boot(): void {
        add_action('rest_api_init', [Routes::class, 'register']);
        add_action('admin_menu', [AdminPage::class, 'register']);
        if (function_exists('wp_register_ability')) {
            add_action('abilities_api_init', [Registrar::class, 'register']);
            add_action('wp_abilities_api_init', [Registrar::class, 'register']);
            add_action('init', [Registrar::class, 'register'], 20);
        }
    }
}

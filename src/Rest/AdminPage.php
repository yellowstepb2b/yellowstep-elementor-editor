<?php
namespace Yellowstep\ElementorEditor\Rest;
use Yellowstep\ElementorEditor\Core;
if (!defined('ABSPATH')) { exit; }
final class AdminPage { public static function register(): void { add_management_page('Yellowstep Elementor Editor','Yellowstep Editor','edit_pages','yellowstep-elementor-editor',[self::class,'render']); } public static function render(): void { if(!current_user_can('edit_pages')){return;} echo '<div class="wrap"><h1>Yellowstep Elementor Editor</h1><p>Version: <strong>'.esc_html(YSEE_VERSION).'</strong></p><h2>REST namespace</h2><code>/wp-json/'.esc_html(Core::REST_NAMESPACE).'/</code><h2>Abilities</h2>'; echo function_exists('wp_register_ability')?'<p>WordPress Abilities API detected.</p>':'<p>WordPress Abilities API not detected. REST endpoints are still available.</p>'; echo '</div>'; } }

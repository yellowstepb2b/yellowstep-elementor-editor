<?php
namespace Yellowstep\ElementorEditor\Rest;
use Yellowstep\ElementorEditor\Core;
if (!defined('ABSPATH')) { exit; }
final class AdminPage {
    public static function register(): void { add_management_page('Yellowstep Elementor Editor','Yellowstep Editor','edit_pages','yellowstep-elementor-editor',[self::class,'render']); }
    public static function render(): void {
        if (!current_user_can('edit_pages')) return;
        echo '<div class="wrap"><h1>Yellowstep Elementor Editor</h1>';
        echo '<p>Version: <strong>'.esc_html(YSEE_VERSION).'</strong></p>';
        echo '<h2>REST namespace</h2><code>/wp-json/'.esc_html(Core::REST_NAMESPACE).'/</code>';
        echo '<h2>Endpoint groups</h2><ul><li>Pages and templates</li><li>Elementor structure</li><li>Semantic page map</li><li>Hero, card and FAQ updates</li><li>Yoast metadata updates</li><li>Snapshots and rollback</li></ul>';
        echo '<p>This plugin is intended for use on development/staging environments first.</p></div>';
    }
}

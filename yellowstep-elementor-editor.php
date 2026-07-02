<?php
/**
 * Plugin Name: Yellowstep Elementor Editor
 * Description: Semantic Elementor editing endpoints for Yellowstep/WPVibe development workflows.
 * Version: 2.0.0
 * Author: Yellowstep / WPVibe
 * Requires at least: 6.5
 * Requires PHP: 8.0
 */
if (!defined('ABSPATH')) { exit; }
define('YSEE_VERSION', '2.0.0');
define('YSEE_FILE', __FILE__);
define('YSEE_PATH', plugin_dir_path(__FILE__));
require_once YSEE_PATH . 'src/Autoloader.php';
\Yellowstep\ElementorEditor\Autoloader::register();
add_action('plugins_loaded', function () {
    \Yellowstep\ElementorEditor\Plugin::boot();
});

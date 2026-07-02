<?php
namespace Yellowstep\ElementorEditor\Elementor;
use Yellowstep\ElementorEditor\Safety\Snapshots;
if (!defined('ABSPATH')) { exit; }
final class DataStore {
    public static function getData(int $postId): array {
        $raw = get_post_meta($postId, '_elementor_data', true);
        if (!$raw) { return []; }
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }
    public static function saveData(int $postId, array $data, string $note=''): void {
        Snapshots::create($postId, $note);
        update_post_meta($postId, '_elementor_data', wp_slash(wp_json_encode($data)));
        update_post_meta($postId, '_elementor_edit_mode', 'builder');
        update_post_meta($postId, '_elementor_version', defined('ELEMENTOR_VERSION') ? ELEMENTOR_VERSION : '');
        self::clearCache($postId); clean_post_cache($postId);
    }
    public static function clearCache(int $postId=0): void {
        if (class_exists('\\Elementor\\Plugin')) { try { \Elementor\Plugin::$instance->files_manager->clear_cache(); } catch (\Throwable $e) {} }
        if ($postId) { delete_post_meta($postId, '_elementor_css'); }
    }
}

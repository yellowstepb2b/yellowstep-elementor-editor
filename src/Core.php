<?php
namespace Yellowstep\ElementorEditor;
use WP_Error; use WP_Query;
if (!defined('ABSPATH')) { exit; }
final class Core {
    public const REST_NAMESPACE = 'yellowstep-editor/v2';
    public static function canEditPages(): bool { return current_user_can('edit_pages'); }
    public static function postCheck(int $postId) {
        $post = get_post($postId);
        if (!$post || !current_user_can('edit_post', $postId)) {
            return new WP_Error('not_found', 'Post not found or not editable.', ['status' => 404]);
        }
        return $post;
    }
    public static function cleanTitle($post): string { return html_entity_decode(get_the_title($post), ENT_QUOTES); }
    public static function listElementorPages(): array {
        $q = new WP_Query(['post_type'=>['page'],'post_status'=>['publish','draft','pending','private'],'posts_per_page'=>200,'meta_key'=>'_elementor_edit_mode','meta_value'=>'builder','orderby'=>'modified','order'=>'DESC','no_found_rows'=>true]);
        $items=[]; foreach ($q->posts as $p) {$items[]=['id'=>$p->ID,'title'=>self::cleanTitle($p),'slug'=>$p->post_name,'status'=>$p->post_status,'modified'=>$p->post_modified,'link'=>get_permalink($p)];}
        return $items;
    }
    public static function listTemplates(): array {
        $q = new WP_Query(['post_type'=>'elementor_library','post_status'=>['publish','draft','private'],'posts_per_page'=>200,'orderby'=>'modified','order'=>'DESC','no_found_rows'=>true]);
        $items=[]; foreach ($q->posts as $p) {$items[]=['id'=>$p->ID,'title'=>self::cleanTitle($p),'type'=>get_post_meta($p->ID,'_elementor_template_type',true),'status'=>$p->post_status];}
        return $items;
    }
}

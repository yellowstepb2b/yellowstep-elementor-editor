<?php
namespace Yellowstep\ElementorEditor\SEO;
if (!defined('ABSPATH')) { exit; }
final class Yoast {
    public static function update(int $postId, ?string $seoTitle=null, ?string $metaDescription=null, ?string $focusKeyphrase=null): array {
        if ($seoTitle!==null) update_post_meta($postId,'_yoast_wpseo_title',sanitize_text_field($seoTitle));
        if ($metaDescription!==null) update_post_meta($postId,'_yoast_wpseo_metadesc',sanitize_text_field($metaDescription));
        if ($focusKeyphrase!==null) update_post_meta($postId,'_yoast_wpseo_focuskw',sanitize_text_field($focusKeyphrase));
        return ['updated'=>true,'post_id'=>$postId,'seo_title'=>get_post_meta($postId,'_yoast_wpseo_title',true),'meta_description'=>get_post_meta($postId,'_yoast_wpseo_metadesc',true),'focus_keyphrase'=>get_post_meta($postId,'_yoast_wpseo_focuskw',true)];
    }
}

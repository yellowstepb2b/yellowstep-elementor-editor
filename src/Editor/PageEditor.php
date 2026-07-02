<?php
namespace Yellowstep\ElementorEditor\Editor;
use WP_Error; use Yellowstep\ElementorEditor\Core; use Yellowstep\ElementorEditor\Elementor\DataStore; use Yellowstep\ElementorEditor\Elementor\Walker; use Yellowstep\ElementorEditor\Semantic\PageMap;
if (!defined('ABSPATH')) { exit; }
final class PageEditor {
    public static function duplicatePage(int $sourceId, string $title='', string $slug='', string $status='draft') {
        $source=Core::postCheck($sourceId); if (is_wp_error($source)) return $source; if (!$title) {$title=$source->post_title.' Copy';}
        $postData=['post_title'=>sanitize_text_field($title),'post_content'=>$source->post_content,'post_excerpt'=>$source->post_excerpt,'post_status'=>in_array($status,['draft','publish','private','pending'],true)?$status:'draft','post_type'=>$source->post_type,'post_parent'=>$source->post_parent,'menu_order'=>$source->menu_order,'post_author'=>get_current_user_id()];
        if ($slug) {$postData['post_name']=sanitize_title($slug);}
        $newId=wp_insert_post($postData,true); if (is_wp_error($newId)) return $newId;
        foreach (get_post_meta($sourceId) as $key=>$values) { if (in_array($key,['_edit_lock','_edit_last','_yellowstep_editor_snapshot'],true)) continue; foreach ($values as $value) add_post_meta($newId,$key,maybe_unserialize($value)); }
        DataStore::clearCache($newId);
        return ['source_id'=>$sourceId,'new_id'=>$newId,'title'=>Core::cleanTitle(get_post($newId)),'status'=>get_post_status($newId),'edit_link'=>get_edit_post_link($newId,'raw'),'permalink'=>get_permalink($newId)];
    }
    public static function updateSectionField(int $postId,string $section,string $field,string $value) {
        $map=PageMap::build($postId); $target=null;
        if ($section==='hero' && $field==='heading') $target=$map['hero']['heading'];
        if ($section==='hero' && in_array($field,['intro','text'],true)) $target=$map['hero']['intro'];
        if (!$target) return new WP_Error('not_found','Semantic field not found.',['status'=>404]);
        $data=DataStore::getData($postId); $updated=Walker::setWidgetSetting($data,$target['id'],$target['setting'],$value);
        if (!$updated) return new WP_Error('not_updated','Could not update field.',['status'=>400]);
        DataStore::saveData($postId,$data,"update {$section}.{$field}");
        return ['updated'=>true,'post_id'=>$postId,'field'=>"{$section}.{$field}",'widget_id'=>$target['id']];
    }
    public static function updateCard(int $postId,int $index,?string $title=null,?string $description=null) {
        $map=PageMap::build($postId); $index=max(1,$index); if (empty($map['cards'][$index-1])) return new WP_Error('not_found','Card not found.',['status'=>404]);
        $card=$map['cards'][$index-1]; $data=DataStore::getData($postId);
        if ($title!==null) Walker::setWidgetSetting($data,$card['id'],'title_text',$title);
        if ($description!==null) Walker::setWidgetSetting($data,$card['id'],'description_text',$description);
        DataStore::saveData($postId,$data,"update card {$index}");
        return ['updated'=>true,'post_id'=>$postId,'card_index'=>$index,'widget_id'=>$card['id']];
    }
    public static function updateFaq(int $postId,int $index,?string $question=null,?string $answer=null) {
        $map=PageMap::build($postId); $index=max(1,$index); if (empty($map['faqs'][$index-1])) return new WP_Error('not_found','FAQ not found.',['status'=>404]);
        $faq=$map['faqs'][$index-1]; $data=DataStore::getData($postId);
        if ($question!==null) Walker::setWidgetSetting($data,$faq['question']['id'],'title',$question);
        if ($answer!==null) Walker::setWidgetSetting($data,$faq['answer']['id'],'editor',$answer);
        DataStore::saveData($postId,$data,"update faq {$index}");
        return ['updated'=>true,'post_id'=>$postId,'faq_index'=>$index];
    }
    public static function replaceText(int $postId,string $oldText,string $newText) {
        if ($oldText==='') return new WP_Error('invalid','old_text is required.',['status'=>400]);
        $data=DataStore::getData($postId); $count=0; Walker::replaceText($data,$oldText,$newText,$count);
        if (!$count) return new WP_Error('no_match','No matching text found.',['status'=>404]);
        DataStore::saveData($postId,$data,'replace text');
        return ['updated'=>true,'post_id'=>$postId,'replacements'=>$count];
    }
}

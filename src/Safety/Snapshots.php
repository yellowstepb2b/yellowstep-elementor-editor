<?php
namespace Yellowstep\ElementorEditor\Safety;
use WP_Error; use Yellowstep\ElementorEditor\Elementor\DataStore;
if (!defined('ABSPATH')) { exit; }
final class Snapshots {
    public const META_KEY='_yellowstep_editor_snapshot';
    public static function create(int $postId,string $note=''): void { add_post_meta($postId,self::META_KEY,['time'=>current_time('mysql'),'user_id'=>get_current_user_id(),'note'=>sanitize_text_field($note),'data'=>get_post_meta($postId,'_elementor_data',true)]); }
    public static function all(int $postId): array { $snapshots=get_post_meta($postId,self::META_KEY); $items=[]; foreach($snapshots as $index=>$snapshot){$items[]=['index'=>$index,'time'=>$snapshot['time']??'','note'=>$snapshot['note']??'','user_id'=>$snapshot['user_id']??''];} return $items; }
    public static function rollback(int $postId, ?int $index=null) { $snapshots=get_post_meta($postId,self::META_KEY); if(empty($snapshots)) return new WP_Error('not_found','No snapshots found.',['status'=>404]); $snapshot=($index===null)?end($snapshots):($snapshots[$index]??null); if(!$snapshot || !isset($snapshot['data'])) return new WP_Error('not_found','Snapshot not found.',['status'=>404]); update_post_meta($postId,'_elementor_data',wp_slash($snapshot['data'])); DataStore::clearCache($postId); return ['rolled_back'=>true,'post_id'=>$postId]; }
}

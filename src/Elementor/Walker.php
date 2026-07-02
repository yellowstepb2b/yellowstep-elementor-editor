<?php
namespace Yellowstep\ElementorEditor\Elementor;
if (!defined('ABSPATH')) { exit; }
final class Walker {
    public static function structure(int $postId): array { $data=DataStore::getData($postId); $items=[]; self::walk($data,$items); return $items; }
    public static function walk(array &$elements, array &$items, array $path=[], int $depth=0): void {
        foreach ($elements as $index=>&$element) {
            $currentPath=array_merge($path,[$index]);
            $settings=isset($element['settings']) && is_array($element['settings']) ? $element['settings'] : [];
            $item=['id'=>$element['id']??null,'elType'=>$element['elType']??null,'widgetType'=>$element['widgetType']??null,'depth'=>$depth,'path'=>$currentPath,'text'=>[]];
            foreach ($settings as $key=>$value) { if (is_string($value) && trim(wp_strip_all_tags($value)) !== '') { $item['text'][$key]=$value; } }
            if ($item['widgetType'] || !empty($item['text'])) { $items[]=$item; }
            if (!empty($element['elements']) && is_array($element['elements'])) { self::walk($element['elements'],$items,array_merge($currentPath,['elements']),$depth+1); }
        }
    }
    public static function setWidgetSetting(array &$elements, string $widgetId, string $settingKey, string $value): bool {
        foreach ($elements as &$element) {
            if (($element['id']??null)===$widgetId) { if (!isset($element['settings']) || !is_array($element['settings'])) {$element['settings']=[];} $element['settings'][$settingKey]=wp_kses_post($value); return true; }
            if (!empty($element['elements']) && is_array($element['elements']) && self::setWidgetSetting($element['elements'],$widgetId,$settingKey,$value)) { return true; }
        }
        return false;
    }
    public static function replaceText(array &$elements, string $oldText, string $newText, int &$count): void {
        foreach ($elements as &$element) {
            if (!empty($element['settings']) && is_array($element['settings'])) { foreach ($element['settings'] as &$value) { if (is_string($value) && strpos($value,$oldText)!==false) { $value=str_replace($oldText,wp_kses_post($newText),$value); $count++; } } }
            if (!empty($element['elements']) && is_array($element['elements'])) { self::replaceText($element['elements'],$oldText,$newText,$count); }
        }
    }
}

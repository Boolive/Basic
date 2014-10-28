<?php
/**
 * menu
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\menu;

use boolive\basic\widget\widget;
use boolive\core\data\Data;
use boolive\core\request\Request;
use boolive\core\values\Rule;

class menu extends widget
{
    function startRule()
    {
        return Rule::arrays(array(
            'REQUEST' => Rule::arrays(array(
                'object' => Rule::entity()->default(null)->required(),// Активный пункт меню (объект, на которого ссылка)
            ))
        ));
    }

    function show($v, Request $request)
    {
        $v['title'] = $this->title->value();
        trace($this->getItems([], $request));
        $v['items'] = array();
//        $v['items'] = $this->itemsToArray($this->getItems([], $request), $request['REQUEST']['object']);
        return parent::show($v, $request);
    }

    /**
     * Преобразование ветки объектов в структуру из массивов для вывода в шаблоне
     * @param array $items Масив объектов - пунктов меню
     * @param Entity $active Активный пункт меню
     * @param bool $sub_active Признак, есть или нет активные подчиненные?
     * @return array
     */
    protected function itemsToArray($items, $active, &$sub_active = false)
    {
        $list = array();
        $have_active = false;
        foreach ($items as $item){
            $children = $item['sub'];
            $item = $item['object'];
            $real = $item->linked();
            $info = array(
                'title' => $item->title->value(),
                'icon' => false,
                'url' => Request::url($real->uri()),
                'active' => $active && $active->eq($real)? 1 : 0
            );
            // Иконка
//            $icon = $item->icon->isExist() ? $item->icon : ($real->icon->isExist()? $real->icon : null);
//            if ($icon && !$icon->isDraft() && !$icon->isHidden()){
//                $info['icon'] = $icon->resize(0,30,Image::FIT_OUTSIDE_LEFT_TOP)->file();
//            }
            // Если заголовок не определен
            if (empty($info['title'])){
                $info['title'] = $real->title->value();
                if (empty($info['title'])) $info['title'] = $real->name();
            }
            if ($children){
                $info['children'] = $this->itemsToArray($children, $active, $sub_active);
                if (!$info['active'] && $sub_active){
                    $info['active'] = 2;
                }
            }
            $have_active = $have_active || $info['active'];
            $list[] = $info;
        }
        $sub_active = $have_active;
        return $list;
    }

    /**
     * Выбор дерева объектов для пунктов меню
     * @param array $cond Услвоие выборки
     * @return array|Entity|mixed|null
     */
    function getItems($cond = array(), Request $request)
    {
//        $is_list = $this->is->find(array('where'=>array('is_link','!=',0), 'group'=>true));
//        foreach ($is_list as $key => $is){
//            $is_list[$key] = $is->linked()->id();
//        }
        $cond['select'] = 'children';
        $cond['struct'] = 'tree';
        $cond['from'] = $request['REQUEST']['object'];
        //$cond['depth'] = array(1, 'max'); // выбрать из хранилища всё дерево меню
        $cond['where'] = array('all', array(
            array('attr', 'is_hidden', '=', 0),
            array('attr', 'is_draft', '=', 0),
//            array('attr', 'is_property', '=', 0),
//            array('is', $is_list)
        ));
        $cond['order'] = ['order','asc'];
//        $cond['group'] = true; // Для выбранных объектов выполнять подвыборки
//        $cond['cache'] = 2; // Кэшировать сущности
        return Data::find($cond);
    }
} 
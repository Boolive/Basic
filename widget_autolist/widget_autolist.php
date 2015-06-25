<?php
/**
 * widget_autolist
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\widget_autolist;

use boolive\basic\widget\widget;
use boolive\core\data\Data;
use boolive\core\request\Request;
use boolive\core\values\Rule;

class widget_autolist extends widget
{
    function startRule()
    {
        return Rule::arrays([
            'REQUEST' => Rule::arrays([
                'object' => Rule::entity()->required(),
            ])
        ]);
    }

    function show($v, Request $request)
    {
        $object = $request['REQUEST']['object'];
        $v['list'] = is_array($v['list']) ? $v['list'] : $this->getList($request);
        $i = 1;
        $v['views'] = array();
        if (is_array($v['list'])){
            $views = $this->linked()->views->linked();
            foreach ($v['list'] as $key => $child_object){
                $request->mix(['REQUEST'=> ['object' => $child_object]]);
                $request->mix(['REQUEST'=> ['number' => $i]]);
                $out = $views->start($request);
                if ($out !== false){
                    $v['views'][$key] = $out;
                    $i++;
                }
            }
        }
        $request->mix(['REQUEST'=> ['object' => $object]]);
        return parent::show($v, $request);
    }

    function getList(Request $request, &$cond = [])
    {
        $cond = Data::unionCond($cond, [
            'from' => $request['REQUEST']['object'],
            'select' => 'children',
            'depth' => 1
        ]);
        return Data::find($cond);
    }
}
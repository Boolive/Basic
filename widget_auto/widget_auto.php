<?php
/**
 * widget_auto
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\widget_auto;

use boolive\basic\widget\widget;
use boolive\core\request\Request;

class widget_auto extends widget
{
    function show($v, Request $request)
    {
        $v['views'] = implode("\n",$this->views->start($request));
        return parent::show($v, $request);
    }
} 
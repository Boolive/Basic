<?php
/**
 * controller_group
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\controller_group;

use boolive\basic\controller\controller;
use boolive\core\commands\Commands;
use boolive\core\data\Data;

class controller_group extends controller
{
    function work($v, $input, Commands $commands)
    {
        $list = Data::find([
            'select' => 'children',
            'from' => $this,
            'key' => 'name',
            'order' => ['order','asc']
        ]);
        foreach ($list as $child) {
            $key = $child->name();
            $out = $child->start($input, $commands);
            if ($out !== false) {
                $v[$key] = $out;
                $input['previous'] = true;
            }
        }
    }
} 
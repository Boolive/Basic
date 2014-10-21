<?php
/**
 * controller_group
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\controller_group;

use boolive\basic\controller\controller;
use boolive\core\commands\Commands;

class controller_group extends controller
{
    function work($v, $input, Commands $commands)
    {
        return $this->startChildren($input, $commands);
    }
}
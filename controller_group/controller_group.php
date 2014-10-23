<?php
/**
 * controller_group
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\controller_group;

use boolive\basic\controller\controller;
use boolive\core\request\Request;

class controller_group extends controller
{
    function work(Request $request)
    {
        return $this->startChildren($request);
    }
}
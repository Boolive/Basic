<?php
/**
 * widget
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\widget;

use boolive\basic\controller\controller;
use boolive\core\request\Request;
use boolive\core\template\Template;

class widget extends controller
{
    function work($v, Request $request)
    {
        $r = $this->res;
        $r->start($request);
        return Template::render($this->file(null, true), $v);
    }
}
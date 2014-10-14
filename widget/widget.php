<?php
/**
 * widget
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\widget;

use boolive\basic\controller\controller;
use boolive\core\commands\Commands;
use boolive\core\data\Data;
use boolive\core\template\Template;

class widget extends controller
{
    function work($v, $input, Commands $commands)
    {
        return Template::render($this->file(null, true), $v);
    }
}
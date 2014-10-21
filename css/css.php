<?php
/**
 * css
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\css;

use boolive\basic\controller\controller;
use boolive\core\commands\Commands;

class css extends controller
{
    function work($v, $input, Commands $commands)
    {
        if ($file = $this->file()){
            $commands->htmlHead('link', array('rel'=>"stylesheet", 'type'=>"text/css", 'href'=>$file));
        }
    }
}
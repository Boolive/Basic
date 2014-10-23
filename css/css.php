<?php
/**
 * css
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\css;

use boolive\basic\controller\controller;
use boolive\core\request\Request;

class css extends controller
{
    function work(Request $request)
    {
        if ($file = $this->file()){
            $request->htmlHead('link', ['rel'=>"stylesheet", 'type'=>"text/css", 'href'=>$file]);
        }
    }
}
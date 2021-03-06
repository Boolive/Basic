<?php
/**
 * Логика подключения JavaScript с учётом зависимостей
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\javascript;

use boolive\basic\controller\controller;
use boolive\core\request\Request;

class javascript extends controller
{
    protected function rule()
    {
        $rule = parent::rule();
//        $rule->arrays[0]['file']->arrays[0]['name']->ospatterns('*.js');
        return $rule;
    }

    function work(Request $request)
    {
        // Исполнение зависимых объектов
        $this->depends->linked()->start($request);
        // Подключение скрипта прототипа - наследование скриптов
//        if (($proto = $this->proto()) && ($proto instanceof self)){
//            $proto->start($this->_commands, $this->_input);
//        }
        // Подключение javascript файла
        if ($file = $this->file()){
            $request->htmlHead('script', ['type'=>'text/javascript', 'src'=>$file, 'text'=>'']);
        }
    }
}
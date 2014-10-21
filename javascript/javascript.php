<?php
/**
 * Логика подключения JavaScript с учётом зависимостей
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\javascript;

use boolive\basic\controller\controller;
use boolive\core\commands\Commands;

class javascript extends controller
{
    protected function rule()
    {
        $rule = parent::rule();
        $rule->arrays[0]['file']->arrays[0]['name']->ospatterns('*.js');
        return $rule;
    }

    function work($v, $input, Commands $commands)
    {
        // Исполнение зависимых объектов
        $this->depends->linked()->start($input, $commands);
        // Подключение скрипта прототипа - наследование скриптов
//        if (($proto = $this->proto()) && ($proto instanceof self)){
//            $proto->start($this->_commands, $this->_input);
//        }
        // Подключение javascript файла
        if ($file = $this->file()){
            $commands->htmlHead('script', array('type'=>'text/javascript', 'src'=>$file, 'text'=>''));
        }
    }
}
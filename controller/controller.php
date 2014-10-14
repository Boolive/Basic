<?php
/**
 * 
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\controller;

use boolive\core\commands\Commands;
use boolive\core\data\Entity;

class controller extends Entity
{
    function start($input, Commands $commands)
    {
        if ($this->startCheck($input, $commands)){
            ob_start();
                // Выполнение своей работы
                $result = $this->work(array(), $input, $commands);
                if (!($result === false || is_array($result))){
                    $result = ob_get_contents().$result;
                }
            ob_end_clean();
            return $result;
        }
        return false;
    }

    function startCheck($input, Commands $commands)
    {
        return true;
    }

    function work($v, $input, Commands $commands)
    {
        return $this->uri();
    }
}
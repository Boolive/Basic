<?php
/**
 * 
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\controller;

use boolive\core\commands\Commands;
use boolive\core\data\Data;
use boolive\core\data\Entity;
use boolive\core\values\Check;
use boolive\core\values\Rule;

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

    function startRule()
    {
        return Rule::null()->ignore('null');
    }

    function startCheck($input, Commands $commands)
    {
        $filtered = Check::filter($input, $this->startRule(), $this->_errors);
        return !isset($error);
    }

    function work($v, $input, Commands $commands)
    {
        return $this->uri();
    }

    /**
     * Запуск всех подчиненных объектов
     * @param array $input Входящие данные
     * @param Commands $commands Входящие и исходящие команды для исполнения контроллерами
     * @param bool $all Признак, запускать все подчиенные (true), или пока не возвратится результат от одного из запущенных (false)
     * @param array $result Значения-заглушки для подчиненных видов. Если в массиве есть ключ с именем вида, то этот вид не исполняется, а испольщуется указанное в элементе значение.
     * @return array Результаты подчиненных объектов. Ключи массива - названия объектов.
     */
    function startChildren($input, $commands, $all = true, $result = array())
    {
        $list = Data::find([
            'select' => 'children',
            'from' => $this,
            'key' => 'name',
            'order' => ['order','asc']
        ]);
        foreach ($list as $child) {
            //$child = $child->linked(true);
            if ($child instanceof controller) {
                $key = $child->name();
                if (!isset($result[$key])) {
                    $out = $child->start($input, $commands);
                    if ($out !== false) {
                        $result[$key] = $out;
                        $input['previous'] = true;
                        if (!$all) return $result;
                    }
                }
            }
        }
        return $result;
    }
}
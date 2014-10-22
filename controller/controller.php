<?php
/**
 * 
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\controller;

use boolive\core\data\Data;
use boolive\core\data\Entity;
use boolive\core\request\Request;
use boolive\core\values\Check;
use boolive\core\values\Rule;

class controller extends Entity
{
    function start(Request $request)
    {
        $request->stash();
        $result = false;
        if ($this->startCheck($request)){
            ob_start();
                // Выполнение своей работы
                $result = $this->work(array(), $request);
                if (!($result === false || is_array($result))){
                    $result = ob_get_contents().$result;
                }
            ob_end_clean();
        }
        $request->unstash();
        return $result;
    }

    function startRule()
    {
        return Rule::null()->ignore('null');
    }

    function startCheck(Request $request)
    {
        $filtered = Check::filter($request->getInput(), $this->startRule(), $this->_errors);
        return !isset($error);
    }

    function work($v, Request $request)
    {
        return $this->uri();
    }

    /**
     * Запуск всех подчиненных объектов
     * @param Request $request Входящие данные и команды для исполнения контроллерами
     * @param bool $all Признак, запускать все подчиенные (true), или пока не возвратится результат от одного из запущенных (false)
     * @param array $result Значения-заглушки для подчиненных видов. Если в массиве есть ключ с именем вида, то этот вид не исполняется, а испольщуется указанное в элементе значение.
     * @return array Результаты подчиненных объектов. Ключи массива - названия объектов.
     */
    function startChildren($request, $all = true, $result = array())
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
                    $out = $child->start($request);
                    if ($out !== false) {
                        $result[$key] = $out;
                        $request->inputMix(['previous'=>true]);
                        if (!$all) return $result;
                    }
                }
            }
        }
        return $result;
    }
}
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
                $result = $this->work($request);
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
        return $request->setFilter($this->startRule());
    }

    function work(Request $request)
    {
        return $this->uri();
    }

    /**
     * Запуск подчиненных контроллеров
     * @param Request $request Входящие данные и команды для обработки контроллерами
     * @param bool $all Признак, запускать все контроллеры (true), или пока не возвратится результат хотябы от одного из запущенных (false)
     * @param array $result Значения-заглушки для подчиненных контроллеров. Если в массиве есть ключ с именем контроллера, то этот контроллер не исполняется, а испольщуется указанное в элементе значение.
     * @return array Результаты исполнения контроллеров. Ключи массива - названия контроллеров.
     */
    function startChildren($request, $all = true, $result = [])
    {
        $list = $this->getCihildrenControllers([], $request);
        foreach ($list as $child) {
            //$child = $child->linked(true);
            if ($child instanceof controller) {
                $key = $child->name();
                if (!isset($result[$key])) {
                    $out = $child->start($request);
                    if ($out !== false) {
                        $result[$key] = $out;
                        $request->mix(['previous'=>true]);
                        if (!$all) return $result;
                    }
                }
            }
        }
        return $result;
    }

    function getCihildrenControllers($cond = [], Request $request)
    {
        $cond = Data::unionCond($cond, [
            'select' => 'children',
            'from' => $this,
            'order' => ['order','asc']
        ]);
        return Data::find($cond);
    }
}
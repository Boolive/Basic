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
    function work(Request $request)
    {
        // Подключение ресурсов (css,js)
        $this->res->start($request);
        return $this->show([], $request);
    }

    /**
     * Отображение виджета
     * @param array $v Значения для шаблона
     * @param Request $request Объект запроса
     * @return string Результат отображения (обычно html)
     * @throws \boolive\core\errors\Error
     */
    function show($v, Request $request)
    {
        // Формирование вывода
        return Template::render($this->file(null, true), $v);
    }
}
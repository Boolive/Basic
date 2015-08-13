<?php
/**
 * Логика подключения сторонней библиотеки с учётом зависимостей
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\vendor_front;

use boolive\basic\controller\controller;
use boolive\core\cli\CLI;
use boolive\core\file\File;
use boolive\core\request\Request;

class vendor_front extends controller
{
    function work(Request $request)
    {
        $name = $this->name();
        $version = $this->version->value();
        if (!is_dir(DIR.'vendor_front/'.$name)){
            CLI::run_php('bowerphp.phar install --save '.$name.'#'.$version, false);
        }
        $files = explode(';',$this->import->value());
        if ($file = $this->file()) $files[] = $file;
        foreach ($files as $file){
            $file = '/vendor_front/'.trim($file);
            switch (File::fileExtention($file)){
                case 'js':
                    $request->htmlHead('script', ['type'=>'text/javascript', 'src'=>$file, 'text'=>'']);
                    break;
                case 'css':
                    $request->htmlHead('link', ['rel'=>"stylesheet", 'type'=>"text/css", 'href'=>$file]);
                    break;
                default:
            }
        }
    }
}
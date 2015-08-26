<?php
/**
 * Название
 *
 * @version 1.0
 * @date 13.08.2015
 * @author Polina Shestakova <paulinep@yandex.ru>
 */
namespace boolive\basic\group;

use boolive\basic\member\member;
use boolive\basic\user\user;
use boolive\core\config\Config;
use boolive\core\data\Data;

class group extends member
{
    private static $config;

    function checkChild(user $user){
         self::$config = Config::read('auth');
         $result = Data::find(array(
                 'from' => self::$config['users-list'],
                 'select' => 'children',
                 'depth' => 'max',
                 'where' => array(
                 ['child', 'email',
                    array('value',  '=', $user->email->value()),
                  ],
                  ),
                 'key' => false,
                 'limit' => array(0, 1),
                 'comment' => 'search if user already exist',
                      ), false);
            if(!empty($result)){
                $user->errors()->_children->email->_attributes->value->dublicate = 'Email не уникален';
                return false;
            }else{
                return true;
            }

    }
} 
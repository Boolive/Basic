<?php
/**
 * user
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\user;

use boolive\core\data\Entity;

class user extends Entity
{

    public function check_access($action, $object)
    {
//        if ($action == 'start' && $object->name() == 'admin'){
//            return false;
//        }else{
            return true;
//        }
    }

    protected  function checkChild(Entity $entity){
        return true;
    }


    public function get_access_condition($action, $object)
    {
        return [];
    }
}
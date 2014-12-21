<?php
/**
 * action
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\action;

use boolive\core\data\Entity;

class action extends Entity
{
    public function get_access_condition($action, $object)
    {
        return [];
    }
}
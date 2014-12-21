<?php
/**
 * role
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\role;

use boolive\core\data\Entity;

class role extends Entity
{
    public function get_access_condition($action, $object)
    {
        return [];
    }
}
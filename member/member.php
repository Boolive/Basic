<?php
/**
 * Название
 *
 * @version 1.0
 * @date 13.08.2015
 * @author Polina Shestakova <paulinep@yandex.ru>
 */
namespace boolive\basic\member;

use boolive\core\data\Entity;

class member extends Entity
{
    protected function checkChild(Entity $child){
        return true;
    }
} 
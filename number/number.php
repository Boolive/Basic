<?php
/**
 * number
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\number;

use boolive\core\data\Entity;
use boolive\core\values\Rule;

class number extends Entity
{
    /**
     * Установка правила на атрибуты
     */
    protected function rule()
    {
        $rule = parent::rule();
        $rule->arrays[0]['value'] = Rule::double();
        return $rule;
    }

    function value($new = null)
    {
        $value = parent::value($new);
        if ($this->_checked){
            return doubleval($value);
        }else{
            return $value;
        }
    }
}
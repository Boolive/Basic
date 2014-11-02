<?php
/**
 * Булево
 * Логическое значение
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\Boolean;

use boolive\core\data\Entity;
use boolive\core\values\Rule;

class boolean extends Entity
{
    /**
     * Установка правила на атрибуты
     */
    protected function rule()
    {
        $rule = parent::rule();
        $rule->arrays[0]['value'] = Rule::bool();
        return $rule;
    }

    function value($new_value = null)
    {
        $value = (bool)parent::value($new_value);
        if ($this->_checked){
            return (bool)$value;
        }else{
            return $value;
        }
    }
}
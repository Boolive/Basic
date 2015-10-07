<?php
/**
 * Название
 *
 * @version 1.0
 * @date 18.09.2015
 * @author Polina Shestakova <paulinep@yandex.ru>
 */
namespace boolive\basic\date;

use boolive\core\data\Entity;
use boolive\core\values\Rule;

class date extends Entity
{
    function rule(){
        return parent::rule()->mix(
                Rule::arrays([
                    'value' =>  Rule::date()
                ])
        );
    }
} 
<?php
/**
 * Название
 *
 * @version 1.0
 * @date 12.08.2015
 * @author Polina Shestakova <paulinep@yandex.ru>
 */
namespace boolive\basic\email;

use boolive\core\data\Entity;
use boolive\core\values\Rule;

class email extends Entity
{
    function rule(){
        return parent::rule()->mix(
                Rule::arrays([
                    'value' =>  Rule::email()
                ])
        );
    }
} 
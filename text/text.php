<?php
/**
 * text
 * @aurhor Vladimir Shestakov
 * @version 1.0
 */
namespace boolive\basic\text;

use boolive\core\data\Entity;

class text extends Entity
{
    private $_file_content;

    function value($new = null)
    {
        $value = parent::value($new);
        if (!isset($this->_file_content)) {
            if (!$value && $this->is_file()) {
                $filename = $this->file(null, true);
                $this->_file_content = file_get_contents($filename);
            } else {
                $this->_file_content = $value;
            }
        }
        return $this->_file_content;
    }
}
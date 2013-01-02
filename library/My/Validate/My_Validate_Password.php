<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class My_Validate_Password extends Zend_Validate_Abstract {

    const DONT_MATCH = 'dontMatch';

    protected $_messageTemplates = array(
        self::DONT_MATCH => 'Podano dwa różne hasła!'
    );

    public function isValid($value, $context = null) {
        $p1 = $value;
        $this->_setValue($p1);
        if (
                is_array($context)
                && isset($context['password'])
                && ($p2 = $context['password'])
                && ($p1 === $p2)
        ) {
            return true;
        }
        $this->_error(self::DONT_MATCH);
        return false;
    }

}

?>

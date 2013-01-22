<?php  
  
class Noodle_Validate_Password extends Zend_Validate_Abstract  
{  
    const DONT_MATCH = 'dontMatch';  
  
    protected $_messageTemplates = array(  
        self::DONT_MATCH => 'Podano dwa różne hasła!'  
    );  
  
    public function isValid($value, $context = null)  
    {  
  
        $p1 = $value;  
        $this->_setValue($p1);  
  
        if (  
            is_array($context)  
            && isset($context['haslo'])  
            && ($p2 = $context['haslo'])  
            && ($p1 === $p2)  
        ) {  
            return true;  
        }  
  
        $this->_error(self::DONT_MATCH);  
        return false;  
    }  
} 
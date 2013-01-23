<?php

class Noodle_View_Helper_IsCanAddTest extends Zend_View_Helper_Abstract {
    
    public static function isCanAddTest() {
        $is = false;
        
        $auth = Zend_Auth::getInstance()->getStorage()->read();
        
        /**
         * @var Application_Model_Uzytkownicy
         */
        $user = Application_Model_UzytkownicyTable::getInstance()->findOneByIdUzytkownicy($auth['idUzytkownicy']);
        if (Application_Model_Uzytkownicy::ROLE_STUDENT != $user->rola) {
            $is = true;
        }
        
        return $is;
    }
}
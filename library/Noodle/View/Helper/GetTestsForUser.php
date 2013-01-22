<?php

class Noodle_View_Helper_GetTestsForUser extends Zend_View_Helper_Abstract {
    
    public static function getTestForUser() {
        $auth = Zend_Auth::getInstance()->getIdentity();
        
        /**
         * @var Application_Model_UzytkownicyHas_TestyTable
         */
        $testyTable = Application_Model_UzytkownicyHas_TestyTable::getInstance();
        $tests = $testyTable->findByUzytkownicy_IdUzytkownicy($auth['idUzytkownicy']);
        
        $testsAll = array();
        foreach ($tests as $test) {
            $sprawdzoneTable = Application_Model_Testy_SprawdzoneTable::getInstance();
            $sprawdzone = $sprawdzoneTable->findOneByIdTesty($test->Testy_idTesty);
            if (!$sprawdzone) {
                $testsAll[] = Application_Model_TestyTable::getInstance()->findOneByIdTesty($test->Testy_idTesty);
            }
        }
        
        return $testsAll;
    }
    
}
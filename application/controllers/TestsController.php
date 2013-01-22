<?php

/**
 * @desc klasa odnośnie rozwiązywania testu
 */

class TestsController extends Noodle_Controller_Action
{
    
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $params = $this->_getAllParams();
        $testAbout = Application_Model_TestyTable::getInstance()->findOneByIdTesty($params['id']);
        $this->view->testAbout = $testAbout;
    }
    
    public function rozwiazAction()
    {
        $params = $this->_getAllParams();
        $testForm = new Application_Form_Test($params['id']);
        if ($this->_session->testForm != null) {
            $testForm = $this->_session->testForm;
        }
        $this->view->testForm = $testForm;
        $this->_session->testForm = null;
    }

    public function saveAction()
    {
        if ($this->getRequest()->isPost()) {
            $params = $this->_getAllParams();
            $testForm = new Application_Form_Test($params['id']);
            if ($testForm->isValid($params)) {
                /**
                 * @var Application_Model_Testy_Sprawdzone
                 */
                $sprawdzone = new Application_Model_Testy_Sprawdzone();
                $sprawdzone->idTesty = $params['id'];
                $sprawdzone->zdobyte_punkty = '-1';
                $auth = Zend_Auth::getInstance()->getIdentity();
                $sprawdzone->Uzytkownicy_idUzytkownicy = $auth['idUzytkownicy'];
                $sprawdzone->save();
                
                $listaZadan = Application_Model_TestyHas_ZadaniaTable::getInstance()->findByTesty_idTesty($params['id']);
                
                foreach ($listaZadan as $zadanie) {
                    /**
                     * @var Application_Model_RozwiazanieZadania
                     */
                    $rozwiazanieZadania = new Application_Model_RozwiazanieZadania();
                    $rozwiazanieZadania->idZadania = $zadanie['Zadania_idZadania'];
                    $rozwiazanieZadania->idUzytkownicy = $auth['idUzytkownicy'];
                    $rozwiazanieZadania->rozwiazanie = $params['zadanie_'.$zadanie['Zadania_idZadania']];
                    $rozwiazanieZadania->zdobyte_pkt = -1;
                    $rozwiazanieZadania->Testy_Sprawdzone_idTesty_Sprawdzone = $sprawdzone->idTesty_Sprawdzone;
                    $rozwiazanieZadania->Uzytkownicy_idUzytkownicy = $auth['idUzytkownicy'];
                    
                    $rozwiazanieZadania->save();
                }
                
                $this->_session->testForm = null;
                return;
            } else {
                $this->_session->testForm = $testForm->setDefaults($params);
                $this->_redirect('/tests/rozwiaz/?id='.$params['id']);
                return;
            }
        }
    }
    
}
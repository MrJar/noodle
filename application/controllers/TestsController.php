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

    /**
     * @des Pokazuje test do rozwiazania po jego id
     */
    public function indexAction()
    {
        $params = $this->_getAllParams();
        $testAbout = Application_Model_TestyTable::getInstance()->findOneByIdTesty($params['id']);
        $this->view->testAbout = $testAbout;
    }
    
    public function listAction()
    {
        $this->view->tests = Application_Model_TestyTable::getInstance()->findAll();
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

    /**
     * 
     * @desc Zapisauje rozwiazany test
     */
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
    
    /**
     * 
     * @desc Dodaje nowy test
     */
    public function addAction()
    {
        if (!Noodle_View_Helper_IsCanAddTest::isCanAddTest()) {
            $this->view->msg = "Nie mozesz dodać testu!";
            return;
        }
        
        $addTestForm = new Application_Form_AddTest();
        $params = $this->_getAllParams();

        if ($this->getRequest()->isPost()) {
            if ($addTestForm->isValid($params)) {
                $test = new Application_Model_Testy();
                $test->Nazwa_testu = $params['Nazwa_testu'];
                $test->data_od = $params['data_od'];
                $test->data_do = $params['data_do'];
                $test->Przedmioty_idPrzedmioty = $params['Przedmioty_idPrzedmioty'];
                $test->save();
                
                $uzytkownicyHas_Przedmioty = Application_Model_UzytkownicyHas_PrzedmiotyTable::getInstance()->findAll();
                foreach ($uzytkownicyHas_Przedmioty as $user) {
                    if ($user->Przedmioty_idPrzedmioty == $params['Przedmioty_idPrzedmioty']) {
                        $uzytkownicyHas_Testy = new Application_Model_UzytkownicyHas_Testy();
                        $uzytkownicyHas_Testy->Uzytkownicy_idUzytkownicy = $user->Uzytkownicy_idUzytkownicy;
                        $uzytkownicyHas_Testy->Testy_idTesty = $test->idTesty;
                        $uzytkownicyHas_Testy->save();
                    }
                }
                
                $zadania = Application_Model_ZadaniaTable::getInstance()->findAll();
                foreach ($zadania as $zadanie) {
                    if ($params['zadanie_'.$zadanie->idZadania]) {
                        $testyHas_Zadania = new Application_Model_TestyHas_Zadania();
                        $testyHas_Zadania->Testy_idTesty = $test->idTesty;
                        $testyHas_Zadania->Zadania_idZadania = $zadanie->idZadania;
                        $testyHas_Zadania->save();
                    }
                }
                
                $this->view->msg = "Nowy test został dodany";
                return;
            } else {
                $addTestForm->setDefaults($params);
            }
        }
        
        $this->view->addTestForm = $addTestForm;
    }
}
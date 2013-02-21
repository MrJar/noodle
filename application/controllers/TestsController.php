<?php

/**
 * @desc klasa odnośnie rozwiązywania testu
 */

class TestsController extends Noodle_Controller_Action
{
    
    const TEST_PER_PAGE = 10;
    
    public function init()
    {
        parent::init();
        $this->auth = Zend_Auth::getInstance();
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
           $testTable = Application_Model_TestyTable::getInstance();
        $test = $testTable->findAll();
        $adapter=$test->toArray();
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($adapter));
        $paginator->setItemCountPerPage(10);
        $page = $this->_request->getParam('strona', 1);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    
    public function pointsAction()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $tests = Application_Model_TestySprawdzoneTable::getInstance()->findByUzytkownicy_idUzytkownicy($auth['idUzytkownicy']);
        
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($tests->toArray()));
        $paginator->setItemCountPerPage(self::TEST_PER_PAGE);
        $page = $this->_request->getParam('strona');
        if (!isset($page)) {
            $page = 1;
        }
        $paginator->setCurrentPageNumber($page);
        $this->view->tests = $paginator;
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
                
                // mozna lepiej
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
    
    public function editAction()
    {
        if (!Noodle_View_Helper_IsCanAddTest::isCanAddTest()) {
            $this->view->msg = "Nie mozesz edytować testu!";
            return;
        }
        
        $params = $this->_getAllParams();
        $editTestForm = new Application_Form_AddTest($params);
        
        if ($this->getRequest()->isPost()) {
            if ($editTestForm->isValid($params)) {
                $test = Application_Model_TestyTable::getInstance()->findOneByIdTesty($params['id']);
                
                // jak ktoś zmienił przedmiot danego testu
                if ($test->Przedmioty_idPrzedmioty != $params['Przedmioty_idPrzedmioty']) {
                    
                    // stare przypisanie usuwamy
                    $uzytkownicyHas_PrzedmiotyTable = Application_Model_UzytkownicyHas_PrzedmiotyTable::getInstance();
                    $uzytkownicyHas_PrzedmiotyOld = $uzytkownicyHas_PrzedmiotyTable->findByPrzedmioty_idPrzedmioty($test->Przedmioty_idPrzedmioty);
                    foreach ($uzytkownicyHas_PrzedmiotyOld as $user) {
                        $uzytkownicyHas_Testy = Application_Model_UzytkownicyHas_TestyTable::getInstance();
                        $userTest = $uzytkownicyHas_Testy->getByIdUzytkownicyAndIdTesty($user->Uzytkownicy_idUzytkownicy, $test->idTesty);
                        $userTest->delete();
                    }
                    
                    // tworzymy nowe przypisania userow ktorzy maja miec testy
                    $uzytkownicyHas_Przedmioty = $uzytkownicyHas_PrzedmiotyTable->findByPrzedmioty_idPrzedmioty($params['Przedmioty_idPrzedmioty']);
                    foreach ($uzytkownicyHas_Przedmioty as $user) {
                        $uzytkownicyHas_Testy = new Application_Model_UzytkownicyHas_Testy();
                        $uzytkownicyHas_Testy->Uzytkownicy_idUzytkownicy = $user->Uzytkownicy_idUzytkownicy;
                        $uzytkownicyHas_Testy->Testy_idTesty = $test->idTesty;
                        $uzytkownicyHas_Testy->save();
                    }
                }
                
                // mozna lepiej
                // zmiana przypisania zadan
                $testyHas_ZadaniaTable = Application_Model_TestyHas_ZadaniaTable::getInstance()->findByTesty_idTesty($test->idTesty);
                foreach ($testyHas_ZadaniaTable as $testy) {
                    $testy->delete();
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
                // koniec zmiana przypisania zadan
                
                // na koncu zapis samego testu
                $test->Nazwa_testu = $params['Nazwa_testu'];
                $test->data_od = $params['data_od'];
                $test->data_do = $params['data_do'];
                $test->Przedmioty_idPrzedmioty = $params['Przedmioty_idPrzedmioty'];
                $test->save();
                
            } else {
                $editTestForm->setDefaults($params);
                $this->view->editTestForm = $editTestForm;
                return;
            }
        } else {
            $test = Application_Model_TestyTable::getInstance()->findOneByIdTesty($params['id'])->toArray();
            $zadaniaForTest = Application_Model_TestyHas_ZadaniaTable::getInstance()->findByTesty_idTesty($params['id']);

            $zadaniaChecked = array();
            foreach ($zadaniaForTest as $zadanieForTest) {
                $zadaniaChecked['zadanie_'.$zadanieForTest->Zadania_idZadania] = true;
            }

            $test = array_merge($test, $zadaniaChecked);
            
            $editTestForm->setDefaults($test);
        }
        $this->view->editTestForm = $editTestForm;
    }
    
    public function genAction()
    {
        $przedmiot = $this->_getParam('Przedmioty_idPrzedmioty', false);
        $ileZadan = $this->_getParam('ilosc', false);
        
        $form = new Application_Form_GenTest(array('przedmiot' => $przedmiot, 'ileZadan' => $ileZadan));
        
                
        if ($this->getRequest()->isPost()) {
            $postData = $this->getAllParams();
            
            if (!empty($postData['Zapisz']) &&$form->isValid($postData)) {
                $params = $postData;
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
               
                $zadania_mdl = Application_Model_ZadaniaTable::getInstance();
                $zadania = $zadania_mdl->getRandom($przedmiot,$ileZadan);
                foreach ($zadania as $zadanie) {
                    
                    //if ($params['zadanie_'.$zadanie['idZadania']]) {
                        $testyHas_Zadania = new Application_Model_TestyHas_Zadania();
                        $testyHas_Zadania->Testy_idTesty = $test['idTesty'];
                        $testyHas_Zadania->Zadania_idZadania = $zadanie['idZadania'];
                        $testyHas_Zadania->save();
                    //}
                }
                
                $this->view->msg = "Nowy test został dodany";
            }
            $values = $form->getValues();
            //var_dump($values);
//            if (isset($values['Przedmioty_idPrzedmioty'])) {
//                Application_Form_GenTest::$przedmiot = $values['Przedmioty_idPrzedmioty'];
//            }
//            if (isset($values['ilosc'])) {
//                Application_Form_GenTest::$ileZadan = $values['ilosc'];
//            }

            $form->populate($postData);
        }
        
        
        $this->view->genTestForm = $form;
        $this->view->msg = false;
    }
    
    public function doneAction()
    {
        $testy_mdl = Application_Model_TestySprawdzoneTable::getInstance();
        $me = $this->auth->getIdentity();
        $id = $me['idUzytkownicy'];
        
        $this->view->tests = ($testy_mdl->getTesty(array('Uzytkownicy_idUzytkownicy = ?',$id)));
    }
}
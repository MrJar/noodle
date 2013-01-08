<?php

class Register2Controller extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body

        $auth = Zend_Auth::getInstance();
        $test = $auth->getStorage()->read();



        if ($test['rola'] == 2) {


            $this->view->form = new Application_Form_Register2();
        }
    }

    public function dodajAction() {


        $params = $this->_getAllParams();
        //$form = new Application_Form_Register();
        //$form2 = new Application_Form_Register2();

        $uzytkownik = new Application_Model_Uzytkownicy();
        $uzytkownik->login = $params['login'];
        $uzytkownik->haslo = sha1($params['haslo']);

        $uzytkownik->email = $params['email'];
        $uzytkownik->rola = $params['rola'];
        $uzytkownik->Grupy_idGrupy = $params['Grupy_idGrupy'];
        $uzytkownik->save();
    }

}
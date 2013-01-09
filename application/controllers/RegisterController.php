<?php

class RegisterController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body

        $auth = Zend_Auth::getInstance()->getStorage()->read();

        switch ($auth['rola']) {
            case Application_Model_Uzytkownicy::ROLE_ADMIN:

                $this->view->form = new Application_Form_Register();
                break;

            case Application_Model_Uzytkownicy::ROLE_LECTURER:

                $this->view->form = new Application_Form_Register2();
                break;
        }
    }

    public function dodajAction() {


        $params = $this->_getAllParams();
        $uzytkownik = new Application_Model_Uzytkownicy();
        $uzytkownik->login = $params['login'];
        $uzytkownik->haslo = sha1($params['haslo']);

        $uzytkownik->email = $params['email'];
        $uzytkownik->rola = $params['rola'];
        $uzytkownik->Grupy_idGrupy = $params['Grupy_idGrupy'];
        $uzytkownik->save();
    }

}
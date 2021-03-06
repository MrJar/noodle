<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginController extends Noodle_Controller_Action {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        
    }

    public function loginAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->_redirect('/login');
        }

        $loginForm = new Application_Form_Login();
        $params = $this->_getAllParams();

        if ($this->getRequest()->isPost()) {
            if ($loginForm->isValid($params)) {

                $usersTable = Application_Model_UzytkownicyTable::getInstance();
                $user = $usersTable->findOneByLogin($params['login']);

                if (sha1($params['haslo']) != $user->haslo) {
                    $this->_redirect('/login');
                    return;
                }

                $auth = Zend_Auth::getInstance();
                $auth->getStorage()->write(array('login' => $user->login, 'idUzytkownicy' => $user->idUzytkownicy, 'rola' => $user->rola));
                $this->_redirect('/');
            }
        }

      
        $this->view->loginForm = $loginForm;
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/login/login');
    }

}

?>

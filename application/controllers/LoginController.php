<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginController extends Noodle_Controller_Action
{

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        if ( $auth->hasIdentity() ) {
            $this->_redirect('/');
        }
        
        $loginForm = new Application_Form_Login();
        $params = $this->_getAllParams();
        
        if ($this->getRequest()->isPost()) {
            if ($loginForm->isValid($params)) {
                
                $usersTable = Application_Model_UzytkownicyTable::getInstance();
                $user = $usersTable->findOneByLogin($params['login']);
                
                if ( sha1($params['haslo']) != $user->haslo ) {
                    $this->_redirect('/');
                    return;
                }
                
                $auth = Zend_Auth::getInstance();
                $auth->getStorage()->write(array('login' => $user->login, 'idUzytkownicy' => $user->idUzytkownicy));
                
                $this->_redirect('/');
                  
            }
          $loginForm->haslo->addError('Błędna próba logowania!');
        }
        
        $this->view->loginForm = $loginForm;
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/login/');
    }
    
    
    public function registerformAction() {
        $this->view->form = new Application_Form_Register();
    }
    
    
    public function registerAction() {
        $this->_helper->viewRenderer('registerform');
        $form = new Application_Form_Register();
        if ($form->isValid($this->getRequest()->getPost())) {
            $User = new Application_Model_UzytkownicyTable();
            
            $dane = array(
                'login' => $form->getValue('login'),
                'haslo' => sh1($form->getValue('haslo')),
                'email' => $form->getValue('email')
            );
            $User->createRow($dane)->save();
            return $this->_helper->redirector(
                            'index', 'index', 'default'
            );
        }
        $this->view->form = $form;
    }
}
?>

<?php

class RegisterController extends Zend_Controller_Action {
   private $form;
    public function init() {
        /* Initialize action controller here */
        
 
            
    }

    public function indexAction() {
        // action body

  

                $this->view->form = $this->_formularze();
                
                
                
               
    }

    public function dodajAction() {

      
         
 $form = new Application_Form_Register();
        $params = $this->_getAllParams();
        $form = $this->_formularze();
        if ($form->isValid($params)) {
            $uzytkownik = new Application_Model_Uzytkownicy();
            $uzytkownik->login = $params['login'];
            $uzytkownik->haslo = sha1($params['haslo']);

            $uzytkownik->email = $params['email'];
            $uzytkownik->rola = $params['rola'];
            $uzytkownik->Grupy_idGrupy = $params['Grupy_idGrupy'];
            $uzytkownik->save();
        } else {
            
           $this->view->form =$form;
            $this->_helper->viewRenderer->setNoController(true);
            $this->_helper->viewRenderer('register/index');
        }
    }

        
            private function _formularze() {
        
   $auth = Zend_Auth::getInstance()->getStorage()->read();

        switch ($auth['rola']) {
            case Application_Model_Uzytkownicy::ROLE_ADMIN:

              return new Application_Form_Register();
                break;

            case Application_Model_Uzytkownicy::ROLE_LECTURER:

              return new Application_Form_Register2();
                break;
        }
    }
  
    
     

}
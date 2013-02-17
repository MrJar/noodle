<?php

class RegisterController extends Noodle_Controller_Action {
   private $form;
    public function init() {
        /* Initialize action controller here */
        parent::init();
 
            
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
            $model = Application_Model_UzytkownicyTable::getInstance();
            $us = $model->findByLogin($params['login']);
            $us=$us->toArray();
            if(count($us) == 0) {
                $uzytkownik = new Application_Model_Uzytkownicy();

                $uzytkownik->login = $params['login'];
                $uzytkownik->haslo = sha1($params['haslo']);

                $uzytkownik->email = $params['email'];
                $uzytkownik->rola = $params['rola'];
                $uzytkownik->Grupy_idGrupy = $params['Grupy_idGrupy'];
                $uzytkownik->save();
            }
            else{
              $form->login->addError("Użytkownik o takim loginie istnieje");
              $this->view->form =$form;
              $this->_helper->viewRenderer->setNoController(true);
              $this->_helper->viewRenderer('register/index');
              
            }
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
<?php

class SubjectController extends Noodle_Controller_Action {
  
    public function init() {
        parent::init();
    }
    
    public function indexAction() {
   
        $this->view->form =new Application_Form_SubjectAdd();
    }
    
    public function addAction() {
        $form = new Application_Form_SubjectAdd();
        $params = $this->_getAllParams();
       
        if ($form->isValid($params)) {
            $subject = new Application_Model_Przedmioty();
            $subject->nazwa = $params['nazwa'];
            $subject->kierunek = $params['kierunek'];

            $subject->grupa = $params['grupa'];
         
            $subject->save();
        } else {
            
           $this->view->form =$form;
            $this->_helper->viewRenderer->setNoController(true);
            $this->_helper->viewRenderer('subject/index');
        }
        } 
    
    public function editAction() {
      
        $params = $this->_getAllParams();
        $subjectTable = Application_Model_PrzedmiotyTable::getInstance();
        $subject = $subjectTable->findOneByIdPrzedmioty($params['idPrzedmioty']);
        $subject->nazwa = $params['nazwa'];
        $subject->kierunek = $params['kierunek'];
        $subject->grupa = $params['grupa'];
        $subject->save();  
        $this->view->msg = "Przedmiot został zmieniony";
        $this->view->editForm = new Application_Form_SubjectAdd();
        
    }
    
    public function removeAction() {
        
        $params = $this->_getAllParams();
        $subjectTable = Application_Model_PrzedmiotyTable::getInstance();
        $subject = $subjectTable->findOneByIdPrzedmioty($params['idPrzedmioty']);
        $subject->delete();       
        $this->view->msg = "Przedmiot został usuniety";  
    }
    
     public function przedmiotyAction()
    {
        $this->view->subject = Application_Model_PrzedmiotyTable::getInstance()->findAll();
    }
}

?>

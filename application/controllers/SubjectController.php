<?php

class SubjectController extends Noodle_Controller_Action {
  
    public function init() {
        parent::init();
    }
    
    public function indexAction() {
  
    }
    
    public function addAction() {
        
        $params = $this->_getAllParams();
        $subject = new Application_Model_Przedmioty();
        $subject->nazwa = $params['nazwa'];
        $subject->kierunek = $params['kierunek'];
        $subject->grupa = $params['grupa'];
        $subject->save(); 
        $this->view->msg = "Nowy przedmiot został dodany";
        $this->view->addForm = new Application_Form_SubjectAdd();
        
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

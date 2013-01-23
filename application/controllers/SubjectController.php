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
        
        $this->view->addForm = new Application_Form_SubjectAdd();
        
    } 
    
    public function editAction() {
      
        $params = $this->_getAllParams();
        $subjectTable = Application_Model_UzytkownicyTable::getInstance();
        $subject = $subjectTable->findOneByLogin($params['idPrzedmioty'], ['nazwa'], ['kierunek'], ['grupa']);
        
        if (($params['idPrzedmioty'])== $subject->idPrzedmioty) {

        $subject = new Application_Model_Przedmioty();
        $subject->nazwa = $params['nazwa'];
        $subject->kierunek = $params['kierunek'];
        $subject->grupa = $params['grupa'];
        $subject->save();  
        $this->view->addForm = new Application_Form_SubjectAdd();
        }
    }
    
    public function removeAction() {
        
        $params = $this->_getAllParams();
        $subjectTable = Application_Model_UzytkownicyTable::getInstance();
        $subject = $subjectTable->findOneByLogin($params['idPrzedmioty']);
        
        if (($params['idPrzedmioty'])== $subject->idPrzedmioty) {
             $subject->delete();       
        $this->view->addForm = new Application_Form_SubjectShow();
        }
        
    }
    
    public function showAction() {
        
        $params = $this->_getAllParams();
        $subjectTable = Application_Model_UzytkownicyTable::getInstance();
        $subject = $subjectTable->findOneByLogin($params['idPrzedmioty'], ['nazwa']);
        
        if (($params['idPrzedmioty'])== $subject->idPrzedmioty) {
        $subject = new Application_Model_Przedmioty();
        $subject->nazwa = $params['nazwa'];   
        $this->view->addForm = new Application_Form_SubjectShow();
         }
    }
    
}

?>

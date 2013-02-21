<?php

class SubjectController extends Noodle_Controller_Action {
  
    const TASK_PER_PAGE = 10;
    
    public function init() {
        parent::init();
    }
    
    public function indexAction() {
        
        if (!$this->_canEditAddTask()) {
            $this->view->msg = 'Nie masz uprawnien do przegladania tej strony';
            return;
        }
        
        $przedmioty = Application_Model_PrzedmiotyTable::getInstance()->findAll()->toArray();
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($przedmioty));
        $paginator->setItemCountPerPage(self::TASK_PER_PAGE);
        $page = $this->_request->getParam('strona');
        if (!isset($page)) {
            $page = 1;
        }
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
   
       // $this->view->subject = Application_Model_PrzedmiotyTable::getInstance()->findAll();
    }
    
    public function addAction() {
        
        if (!$this->_canEditAddTask()) {
            $this->view->msg = 'Nie możesz edytować, dodwać lub usuwać przedmiotow';
            return;
        }
        
        $form = new Application_Form_SubjectAdd();
        $params = $this->_getAllParams();
       
        if ($this->getRequest()->isPost()) {
        if ($form->isValid($params)) {
            $subject = new Application_Model_Przedmioty();
            $subject->nazwa = $params['nazwa'];
            $subject->kierunek = $params['kierunek'];
            $subject->grupa = $params['grupa'];        
            $subject->save();
            $this->view->msg = 'Przedmiot został dodany';
        } else {
            
           $this->view->form =$form;
            $this->_helper->viewRenderer->setNoController(true);
            $this->_helper->viewRenderer('subject/index');
        }
        }
        $this->view->SubjectAddForm = $form;
        } 
    
    public function editAction()
    {
        if (!$this->_canEditAddTask()) {
            $this->view->msg = 'Nie możesz edytować, dodwać lub usuwać zadań';
            return;
        }
        
        $params = $this->_getAllParams();
        $editSubjectForm = new Application_Form_SubjectAdd(array('idPrzedmioty' => $params['idPrzedmioty']));
        
        $Przedmioty = Application_Model_PrzedmiotyTable::getInstance()->findOneByIdPrzedmioty($params['idPrzedmioty']);
        
        if ($this->getRequest()->isPost()) {
            if ($editSubjectForm->isValid($params)) {
                
               $Przedmioty->nazwa = $params['nazwa'];
               $Przedmioty->kierunek = $params['kierunek'];
               $Przedmioty->grupa = $params['grupa'];
               $Przedmioty->save();     
               $this->view->msg = 'Zadanie zostało zapisane';
            }
        }else {
            $editSubjectForm->setDefaults($Przedmioty->toArray());
        }
        
        $this->view->SubjectEditForm = $editSubjectForm;
    }
    
    public function deleteAction() {
        
        if (!$this->_canEditAddTask()) {
            $this->view->msg = 'Nie możesz edytować, dodwać lub usuwać przedmiotow';
            return;
        }
        $idPrzedmioty = $this->_getParam('idPrzedmioty');
        
        $subject = Application_Model_PrzedmiotyTable::getInstance()->findOneByIdPrzedmioty($idPrzedmioty);
        $subject->delete();       
        $this->view->msg = "Przedmiot został usuniety";  
    }
    
    protected function _canEditAddTask()
    {
        $is = false;
        $auth = Zend_Auth::getInstance()->getStorage()->read();

        $user = Application_Model_UzytkownicyTable::getInstance()->findOneByIdUzytkownicy($auth['idUzytkownicy']);
        if (Application_Model_Uzytkownicy::ROLE_STUDENT != $user->rola) {
            $is = true;
        }
        
        return $is;
    }
}

?>

<?php

class TaskController extends Noodle_Controller_Action
{
    
    const TASK_PER_PAGE = 10;
    
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $zadania = Application_Model_ZadaniaTable::getInstance()->findAll()->toArray();
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($zadania));
        $paginator->setItemCountPerPage(self::TASK_PER_PAGE);
        $page = $this->_request->getParam('strona');
        if (!isset($page)) {
            $page = 1;
        }
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    
    public function addAction()
    {
        if ($this->_canEditAddTask()) {
            $this->view->msg = 'Nie możesz edytować, dodwać lub usuwać zadań';
            return;
        }
        
        $params = $this->_getAllParams();
        $addTaskForm = new Application_Form_AddTask();
        
        if ($this->getRequest()->isPost()) {
            if ($addTaskForm->isValid($params)) {
                $task = new Application_Model_Zadania();
                $task->rozwiazanie = $params['rozwiazanie'];
                $task->tresc = $params['tresc'];
                $task->danetestowe = $params['danetestowe'];
                $task->wyniki = $params['wyniki'];
                $task->punkty = $params['punkty'];
                $task->Przedmioty_idPrzedmioty = $params['Przedmioty_idPrzedmioty'];
                $task->save();
                
                $this->view->msg = 'Zadanie zostało zapisane';
                return; 
            }
        }
        
        $this->view->addTaskForm = $addTaskForm;
    }
    
    public function editAction()
    {
        if ($this->_canEditAddTask()) {
            $this->view->msg = 'Nie możesz edytować, dodwać lub usuwać zadań';
            return;
        }
        
        $params = $this->_getAllParams();
        $editTaskForm = new Application_Form_AddTask(array('id' => $params['id']));
        
        $task = Application_Model_ZadaniaTable::getInstance()->findOneByIdZadania($params['id']);
        
        if ($this->getRequest()->isPost()) {
            if ($editTaskForm->isValid($params)) {
                $task->rozwiazanie = $params['rozwiazanie'];
                $task->tresc = $params['tresc'];
                $task->danetestowe = $params['danetestowe'];
                $task->wyniki = $params['wyniki'];
                $task->punkty = $params['punkty'];
                $task->Przedmioty_idPrzedmioty = $params['Przedmioty_idPrzedmioty'];
                $task->save();
                
                $this->view->msg = 'Zadanie zostało zapisane';
                return;
            }
        } else {
            $editTaskForm->setDefaults($task->toArray());
        }
        
        $this->view->editTaskForm = $editTaskForm;
    }
    
    public function deleteAction()
    {
        if ($this->_canEditAddTask()) {
            $this->view->msg = 'Nie możesz edytować, dodwać lub usuwać zadań';
            return;
        }
        
        $id = $this->_getParam('id');
        
        $task = Application_Model_ZadaniaTable::getInstance()->findOneByIdZadania($id);
        
        if (!$this->_canRemoveTask($id)) {
            $this->view->msg = 'Nie możesz usunąć zadania ponieważ jest w teście';
            return;
        }
        
        $this->view->msg = 'Zadanie usuniete';
        $task->delete();
    }
    
    protected function _canRemoveTask($id)
    {
        $testy = Application_Model_TestyHas_ZadaniaTable::getInstance()->findByZadania_idZadania($id);       
        if ($testy->count() == 0) {
            return true;
        }
        return false;
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
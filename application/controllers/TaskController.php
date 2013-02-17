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
        $params = $this->_getAllParams();
        $addTaskForm = new Application_Form_AddTask();
        
        if ($this->getRequest()->isPost()) {
            if ($addTaskForm->isValid($params)) {
                $task = new Application_Model_Zadania();
                $task->rozwiazanie = $params['rozwiazanie'];
                $task->tresc = $params['tresc'];
                $task->danetestowe = $params['danetestowe'];
                $task->wyniki = $params['wynik'];
                $task->punkty = $params['punkty'];
                $task->Przedmioty_idPrzedmioty = $params['Przedmioty_idPrzedmioty'];
                $task->save();
                return;
            }
        }
        
        $this->view->addTaskForm = $addTaskForm;
    }
}
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class UsersController extends Noodle_Controller_Action {

    public function init() {
        parent::init();
    }

    public function indexAction() { //  $this->_helper->layout->disableLayout();
        $testTable = Application_Model_UzytkownicyTable::getInstance();

        $test = $testTable->findAll();

        $lala = $test->toArray();
        
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($lala));
        $paginator->setItemCountPerPage(10);
        $page = $this->_request->getParam('strona', 1);
        $paginator->setCurrentPageNumber($page);


        $this->view->paginator = $paginator;
    }

}

?>

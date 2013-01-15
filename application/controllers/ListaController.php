<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ListaController extends Noodle_Controller_Action
{
    
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    { //  $this->_helper->layout->disableLayout();
          $testTable = Application_Model_UzytkownicyTable::getInstance();
        $test = $testTable->findAll();
        $this->view->test = $test;
   
    }
    
    
    
}
?>

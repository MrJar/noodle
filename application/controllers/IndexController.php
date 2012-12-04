<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function testDoctrineAction()
    {
        $testTable = Application_Model_TestTable::getInstance();
        $test = $testTable->findAll();
        $this->view->test = $test;
    }
 
 

}


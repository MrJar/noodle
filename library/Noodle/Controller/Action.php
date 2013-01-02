<?php

/**
 * @desc w tej klasie sa akcje dostępne w każdym kontrolerze dziedziczacym.
 */
class Noodle_Controller_Action extends Zend_Controller_Action{

    
    protected $_controller;
    
    protected $_action;

    public function init()
    {
        $this->_controller = $this->_getParam('controller');
        $this->view->controller = $this->_controller;
        parent::init();

        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity() && $this->_controller != 'login') {
            $this->_redirect('/login/');
        }

        if ( $auth->hasIdentity() ) {
            $user = $auth->getIdentity();
            $this->view->login = $user['login'];
        }
    }
}
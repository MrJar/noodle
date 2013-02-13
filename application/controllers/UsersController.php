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
    }

    public function studentAction() {

        $testTable = Application_Model_UzytkownicyTable::getInstance();
        $test = $testTable->findBy('rola', 1);
        $lala = $test->toArray();
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($lala));
        $paginator->setItemCountPerPage(10);
        $page = $this->_request->getParam('strona', 1);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function lecturerAction() {

        $testTable = Application_Model_UzytkownicyTable::getInstance();
        $test = $testTable->findBy('rola', 2);
        $lala = $test->toArray();
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($lala));
        $paginator->setItemCountPerPage(10);
        $page = $this->_request->getParam('strona', 1);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function editstudentAction() {
        // pobieramy parametr z adresu
        $id = $this->_request->getParam('id');
        $modelUzytkownicy = Application_Model_UzytkownicyTable::getInstance();
        $user = $modelUzytkownicy->find($id);
        $form = new Application_Form_EditUser();
        $params = $this->_getAllParams();
        $form->setAction('/users/editstudent/id/' . $this->_request->getParam('id'))
                ->setMethod('post');
        // usuwamy pole z hasłem
        $form->removeElement('haslo');
        $form->removeElement('haslo2');
        if ($this->getRequest()->isPost()) {

            $email = $form->getValue('email');
            $login = $form->getValue('login');

            $rola = $form->getValue('rola');
            $Grupy_idGrupy = $form->getValue('Grupy_idGrupy');

            if ($form->isValid($params)) {
                $user->login = $params['login'];
                $user->email = $params['email'];
                $user->rola = $params['rola'];
                $user->Grupy_idGrupy = $params['Grupy_idGrupy'];
                $user->save();

                return $this->_redirect('/users/student');
            }

            if ($form->isErrors()) {
                $form->populate($_POST);
            }
        } else {
            $form->populate($user->toArray());
        }
        $this->view->form = $form;
    }
    
    public function deletestudentAction() {
        $id = $this->_request->getParam('id');
        $modelUzytkownicy = Application_Model_UzytkownicyTable::getInstance();
       $user = $modelUzytkownicy->find($id);
        if ($user) {
            $user->idUzytkownicy = $id;
            $user->delete();

}
        
        return $this->_redirect('/users/student');
    }

    
        public function editlecturerAction() {
        // pobieramy parametr z adresu
        $id = $this->_request->getParam('id');
        $modelUzytkownicy = Application_Model_UzytkownicyTable::getInstance();
        $user = $modelUzytkownicy->find($id);
        $form = new Application_Form_EditUser();
        $params = $this->_getAllParams();
        $form->setAction('/users/editlecturer/id/' . $this->_request->getParam('id'))
                ->setMethod('post');
        // usuwamy pole z hasłem
        $form->removeElement('haslo');
        $form->removeElement('haslo2');
        if ($this->getRequest()->isPost()) {

            $email = $form->getValue('email');
            $login = $form->getValue('login');

            $rola = $form->getValue('rola');
            $Grupy_idGrupy = $form->getValue('Grupy_idGrupy');

            if ($form->isValid($params)) {
                $user->login = $params['login'];
                $user->email = $params['email'];
                $user->rola = $params['rola'];
                $user->Grupy_idGrupy = $params['Grupy_idGrupy'];
                $user->save();

                return $this->_redirect('/users/lecturer');
            }

            if ($form->isErrors()) {
                $form->populate($_POST);
            }
        } else {
            $form->populate($user->toArray());
        }
        $this->view->form = $form;
    }
    
    public function deletelecturerAction() {
        $id = $this->_request->getParam('id');
        $modelUzytkownicy = Application_Model_UzytkownicyTable::getInstance();
       $user = $modelUzytkownicy->find($id);
        if ($user) {
            $user->idUzytkownicy = $id;
            $user->delete();

}
        
        return $this->_redirect('/users/lecturer');
    }

    
    
               


}


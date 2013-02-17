<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class UsersController extends Noodle_Controller_Action {

    public function init() {
        parent::init();
    }

    public function studentAction() {

        $testTable = Application_Model_UzytkownicyTable::getInstance();
        $test = $testTable->findBy('rola', 1);
        $adapter=$test->toArray();
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($adapter));
        $paginator->setItemCountPerPage(10);
        $page = $this->_request->getParam('strona', 1);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function lecturerAction() {

        $testTable = Application_Model_UzytkownicyTable::getInstance();
        $test = $testTable->findBy('rola', 2);
        $adapter=$test->toArray();
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($adapter));
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


        if ($this->getRequest()->isPost()) {
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

    public function searchAction() {

        $this->view->form = new Application_Form_SearchUser();
        if ($this->getRequest()->isPost() || ($this->getRequest()->isGet() && $this->getRequest()->getParam('Szukaj')!==NULL)) {
            $this->view->ispost = 'post';
            $params = $this->_getAllParams();

            if ($params['search'] == "login") {
                $model = Application_Model_UzytkownicyTable::getInstance();
                $users = $model->findByLogin($params['param']);
            } elseif ($params['search'] == "grupa") {
                $model = Application_Model_UzytkownicyTable::getInstance();
                $users = $model->findByGrupy_idGrupy($params['param']);
            } elseif ($params['search'] == "rola") {
                $model = Application_Model_UzytkownicyTable::getInstance();
                $users = $model->findByRola($params['param']);
            }

            $adapter= $users->toArray();
            $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($adapter));
            $paginator->setItemCountPerPage(10);
            $page = $this->_request->getParam('strona', 1);
            $paginator->setCurrentPageNumber($page);
            $this->view->paginator = $paginator;
        }
    }

}


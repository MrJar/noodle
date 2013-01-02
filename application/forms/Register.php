<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Application_Form_Register extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        $view = Zend_Layout::getMvcInstance()->getView();
        $url = $view->url(array(
            'controller' => 'login', 'action' => 'register'
                ));
        $this->setAction($url);
        $this->addElement(
                'text', 'login', array(
            'label' => 'Username:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'Db_NoRecordExists',
                    true,
                    array('table' => 'Uzytkownicy', 'field' => 'login')
                ),
            )
                )
        );
        $this->addElement(
                'text', 'email', array(
            'label' => 'Email:',
            'required' => true,
            'filters' => array('StringTrim'),
                )
        );
        $this->addElement(
                'password', 'haslo', array(
            'label' => 'Password:',
            'required' => true,
                )
        );
        $this->addElement(
                'password', 'password2', array(
            'label' => 'Repeat password:',
            'required' => true,
                )
        );
        $this->password2->addValidator(new My_Validate_Password());
        $this->addElement(
                'submit', 'submit', array(
            'ignore' => true,
            'label' => 'Rejestruj',
                )
        );
    }

}
?>

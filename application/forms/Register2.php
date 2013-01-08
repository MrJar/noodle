<?php

class Application_Form_Register2 extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */

        $this->setAction('/register2/dodaj')->setMethod('post');

        $this->addElement(new Zend_Form_Element_Text('login',
                        array(
                            'label' => 'Login',
                           
                            'required' => true
                )));


        $this->addElement(new Zend_Form_Element_Password('haslo',
                        array(
                            'label' => 'Haslo',
                            'required' => true
                )));

        $this->addElement(new Zend_Form_Element_Text('email',
                        array(
                            'label' => 'Email',
                            'validators' => array(
                                'EmailAdress'
                            ),
                            'required' => true
                )));

        $this->addElement(new Zend_Form_Element_Select('rola',
                        array(
                            'label' => 'Rola',
                            'multiOptions' => array(
                                '1' => 'Student',
                            ),
                            'required' => true
                )));
        $this->addElement(new Zend_Form_Element_Select('Grupy_idGrupy',
                        array(
                            'label' => 'Grupa',
                            'multiOptions' => array(
                                '1' => 'Grupa 1',
                                '2' => 'Grupa 2',
                                '3' => 'Grupa 3',
                            ),
                            'required' => true
                )));



        $this->addElement('submit', 'Zarejestruj', array(
            'label' => 'Zarejestruj',
            'required' => true
        ));
    }

}
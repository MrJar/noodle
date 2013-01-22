<?php

class Application_Form_Login extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */


        $this->setAction('/login/login')->setMethod('post');

        $this->addElement(new Zend_Form_Element_Text('login',
                        array(
                            'label' => 'Login',
                            'validators' => array(
                                'NotEmpty'
                            ),
                            'required' => true
                )));
        $this->login->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));

        $this->addElement(new Zend_Form_Element_Password('haslo',
                        array(
                            'label' => 'Hasło',
                            'validators' => array(
                                'NotEmpty',
                                array('StringLength', false, array('6'))
                            ),
                            'required' => true
                )));
        $this->haslo->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::TOO_SHORT => "'%value%' jest mniej niż 6 znaków"
        ));

        $this->haslo->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));

        $this->addElement('submit', 'Zaloguj', array(
            'label' => 'Zaloguj',
            'required' => true
        ));
    }

}


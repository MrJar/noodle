<?php

class Application_Form_EditUser extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */

        

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


       
        $this->addElement(new Zend_Form_Element_Text('email',
                        array(
                            'label' => 'Email',
                            'validators' => array(
                                'NotEmpty',
                                'EmailAddress'
                            ),
                            'required' => true
                )));
        $this->email->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        $this->email->getValidator('EmailAddress')->setMessages(array(
            Zend_Validate_EmailAddress::INVALID_FORMAT => "'%value%' podałeś nieprawidłowy format adresu email. Przykład : local-part@hostname"
        ));

        $this->addElement(new Zend_Form_Element_Select('rola',
                        array(
                            'label' => 'Rola',
                            'multiOptions' => array(
                                '1' => 'Student',
                                '2' => 'Wykładowca',
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
            'label' => 'Zapisz',
            'required' => true
        ));
    }

}
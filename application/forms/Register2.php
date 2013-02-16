<?php

class Application_Form_Register2 extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */

        $this->setAction('/register/dodaj')->setMethod('post');

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
                            'label' => 'Haslo',
                            'validators' => array(
                                'NotEmpty',
                                array('StringLength', false, array('6'))
                            ),
                            'required' => true
                )));
        $this->haslo->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        $this->haslo->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::TOO_SHORT => "'%value%' jest mniej niż 6 znaków"
        ));

        $this->addElement(new Zend_Form_Element_Password('haslo2',
                        array(
                            'label' => 'Powtórz hasło',
                            'validators' => array(
                                'NotEmpty',
                                array('StringLength', false, array('6'))
                            ),
                            'required' => true
                )));
        $this->haslo2->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        $this->haslo2->addValidator(new Noodle_Validate_Password());
        $this->haslo2->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::TOO_SHORT => "'%value%' jest mniej niż 6 znaków"
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
                            ),
                            'required' => true
                )));
              $grupy = Application_Model_GrupyTable::getInstance()->findAll()->toArray();
        
        
        foreach ($grupy as $grupa) {
            if($grupa['nazwa']!="admins")
            $wybierzGrupe[$grupa['idGrupy']] = $grupa['nazwa'];
        }
        
        
        
        
        $this->addElement(new Zend_Form_Element_Select('Grupy_idGrupy',
                        array(
                            'label' => 'Grupa',
                            'multiOptions' => $wybierzGrupe,
                            'required' => true
                )));



        $this->addElement('submit', 'Zarejestruj', array(
            'label' => 'Zarejestruj',
            'required' => true
        ));
    }

}
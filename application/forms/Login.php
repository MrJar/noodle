<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
     
        
         $this->setAction('/login/index')->setMethod('post');
        
        $this->addElement(new Zend_Form_Element_Text('login',
                array(
                    'label' => 'Login',
                    'validators' => array(
                        'EmailAddress'
                    ),
                    'required' => true
                )));
        
        $this->addElement(new Zend_Form_Element_Password('haslo',
                array(
                    'label' => 'Hasło',
                    'validators' => array(
                        array('StringLength',false,array('6'))
                    ),
                    'required' => true
                )));
        
        $this->addElement('submit', 'Zaloguj' ,
                array(
                    'label' => 'Zaloguj',
                    'required' => true
                ));
        
   

    }
    
     

}

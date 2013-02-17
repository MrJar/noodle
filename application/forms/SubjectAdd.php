<?php

class Application_Form_SubjectAdd extends Zend_Form {
    
    public function init() {
       
        $this->setAction('/subject/add')->setMethod('post');
        $this->addElement(new Zend_Form_Element_Text('nazwa',
                        array(
                            'label' => 'Nazwa',
                            'validators' => array(
                                'NotEmpty'), 
                            'required' => true
                )));
        $this->nazwa->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        $this->addElement(new Zend_Form_Element_Text('kierunek',
                        array(
                            'label' => 'Kierunek',
                            'validators' => array(
                                'NotEmpty'), 
                            'required' => true
                )));
        
        $this->kierunek->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        $this->addElement(new Zend_Form_Element_Text('grupa',
                        array(
                            'label' => 'Grupa',
                            'validators' => array(
                                'NotEmpty'), 
                            'required' => true
                )));
        $this->grupa->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        
        $this->addElement('submit', 'Zarejestruj', array(
            'label' => 'Zarejestruj',
            'required' => true
        ));
        
    }
    
}

?>

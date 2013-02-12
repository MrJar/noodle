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
        $this->addElement(new Zend_Form_Element_Text('kierunek',
                        array(
                            'label' => 'Kierunek',
                            'validators' => array(
                                'NotEmpty'), 
                            'required' => true
                )));
        $this->addElement(new Zend_Form_Element_Text('grupa',
                        array(
                            'label' => 'Grupa',
                            'validators' => array(
                                'NotEmpty'), 
                            'required' => true
                )));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Dodaj',
            'required' => true
        ));
        
    }
    
}

?>

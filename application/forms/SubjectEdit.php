<?php

class Application_Form_SubjectEdit extends Zend_Form {
    
    public function init() {
       
        $this->setAction('/subject/edit/?id='.$this->_idPrzedmioty)->setMethod('post');
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
        
        $this->addElement('submit', 'edit', array(
            'label' => 'Zmien',
            'required' => true
        ));
        
    }

}

?>

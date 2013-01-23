<?php

class Application_Form_SubjectAdd extends Zend_Form {
    
    public function init() {
       
        $this->setAction('/subject/add')->setMethod('post');
        $this->addElement(new Zend_Form_Element_Text('nazwa',
                        array(
                            'label' => 'Nazwa',
                            'required' => true
                )));
        $this->addElement(new Zend_Form_Element_Text('kierunek',
                        array(
                            'label' => 'Kierunek',
                            'required' => true
                )));
        $this->addElement(new Zend_Form_Element_Text('grupa',
                        array(
                            'label' => 'Grupa',
                            'required' => true
                )));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Dodaj',
            'required' => true
        ));
        
    }
    
}

class Application_Form_SubjectEdit extends Zend_Form {
    
    public function init() {
       
        $this->setAction('/subject/edit')->setMethod('post');
        $this->addElement(new Zend_Form_Element_Text('nazwa',
                        array(
                            'label' => 'Nazwa',
                            'required' => true
                )));
        $this->addElement(new Zend_Form_Element_Text('kierunek',
                        array(
                            'label' => 'Kierunek',
                            'required' => true
                )));
        $this->addElement(new Zend_Form_Element_Text('grupa',
                        array(
                            'label' => 'Grupa',
                            'required' => true
                )));
        
        $this->addElement('submit', 'edit', array(
            'label' => 'Zmien',
            'required' => true
        ));
        
    }
    
}

class Application_Form_SubjectShow extends Zend_Form {
    
    public function init() {
       
        $this->setAction('/subject/edit')->setMethod('post');
        $this->addElement(new Zend_Form_Element_Text('nazwa',
                        array(
                            'label' => 'Nazwa',
                            'required' => true
                )));
        
        $this->addElement('submit', 'przejscie do edycji?', array(
            'label' => 'edytuj',
            'required' => true
        ));
        
        $this->addElement('submit', 'delete', array(
            'label' => 'usun',
            'required' => true
        ));
        
    }
}


?>

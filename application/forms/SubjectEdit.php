<?php

class Application_Form_SubjectEdit extends Zend_Form {
    
    private $_idPrzedmioty = null;
 
    public function __construct($options = null) {
        $this->_idPrzedmioty = $options;
        parent::__construct();
    }
    
    public function init() {
       
        $this->setAction('/subject/edit/?idPrzedmioty='.$this->_idPrzedmioty)->setMethod('post');
        $this->addElement(new Zend_Form_Element_Text('nazwa',
                        array(
                            'label' => 'Nazwa przedmoitu',
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
        
       $grupy = Application_Model_GrupyTable::getInstance()->findAll()->toArray();
        
        
        foreach ($grupy as $grupa) {
            if($grupa['nazwa']!="admins")
            $wybierzGrupe[$grupa['idGrupy']] = $grupa['nazwa'];
        }
        $this->addElement(new Zend_Form_Element_Select('grupa',
                        array(
                            'label' => 'Grupa',
                            'multiOptions' => $wybierzGrupe, 
                            'required' => true
                )));
       
        
        $this->addElement('submit', 'Zarejestruj', array(
            'label' => 'Zmien',
            'required' => true
        ));
        
    }
    
}

?>

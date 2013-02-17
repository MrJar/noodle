<?php

class Application_Form_AddTask extends Zend_Form {

    private $_idTask = null;

    public function __construct($options = null) {
        $this->_idTask = $options['id'];
        parent::__construct();
    }
    
    public function init() {
        if ($this->_idTask != null) {
            $this->setAction('/task/edit/?id='.$this->_idTask)->setMethod('post');
        } else {
            $this->setAction('/task/add')->setMethod('post');
        }
        
        $this->addElement(new Zend_Form_Element_Text('tresc', 
                array(
                    'label' => 'Treść',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'require' => true
                )));
        $this->tresc->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        
        $this->addElement(new Zend_Form_Element_Text('rozwiazanie', 
                array(
                    'label' => 'Rozwiazanie',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'require' => true
                )));
        $this->tresc->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        
        $this->addElement(new Zend_Form_Element_Text('danetestowe', 
                array(
                    'label' => 'Dane testowe',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'require' => true
                )));
        
        $this->addElement(new Zend_Form_Element_Text('wynik', 
                array(
                    'label' => 'Wynik',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'require' => true
                )));
        
        $this->addElement(new Zend_Form_Element_Text('punkty', 
                array(
                    'label' => 'Punkty',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'require' => true
                )));
        
        $przedmioty = Application_Model_PrzedmiotyTable::getInstance()->findAll()->toArray();
        
        $przedAdd = array();
        foreach ($przedmioty as $przedmiot) {
            $przedAdd[$przedmiot['idPrzedmioty']] = $przedmiot['nazwa'];
        }
        
        $this->addElement(new Zend_Form_Element_Select('Przedmioty_idPrzedmioty',
                        array(
                            'label' => 'Przedmiot',
                            'multiOptions' => $przedAdd,
                            'required' => true
                )));
        
        $this->addElement('submit', 'Dodaj', array(
            'label' => 'Dodaj',
            'required' => true
        ));
    }
}
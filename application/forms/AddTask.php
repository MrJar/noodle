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
            $labelForSubmit = 'Zapisz';
        } else {
            $this->setAction('/task/add')->setMethod('post');
            $labelForSubmit = 'Dodaj';
        }
        
        $this->addElement(new Zend_Form_Element_Text('tresc', 
                array(
                    'label' => 'Treść',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'required' => true
                )));
        $this->tresc->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        
        $this->addElement(new Zend_Form_Element_Text('rozwiazanie', 
                array(
                    'label' => 'Rozwiazanie',
                    'validators' => array(
                                'NotEmpty',
                            ),
                    'required' => true
                )));
        $this->rozwiazanie->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        
        $this->addElement(new Zend_Form_Element_Text('danetestowe', 
                array(
                    'label' => 'Dane testowe',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'required' => true
                )));
        $this->danetestowe->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        
        $this->addElement(new Zend_Form_Element_Text('wyniki', 
                array(
                    'label' => 'Wynik',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'required' => true
                )));
        $this->wyniki->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        
        
        $this->addElement(new Zend_Form_Element_Text('punkty', 
                array(
                    'label' => 'Punkty',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'required' => true
                )));
        $this->punkty->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY => "Wartość jest wymagana i nie może być pusta"
        ));
        
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
            'label' => $labelForSubmit,
            'required' => true
        ));
    }
}
<?php

class Application_Form_AddTest extends Zend_Form {

    private $_idTesty = null;

    public function __construct($options = null) {
        $this->_idTesty = $options['id'];
        parent::__construct();
    }
    
    public function init() {
        if ($this->_idTesty != null) {
            $this->setAction('/tests/edit/?id='.$this->_idTesty)->setMethod('post');
        } else {
            $this->setAction('/tests/add')->setMethod('post');
        }

        $zadania = Application_Model_ZadaniaTable::getInstance()->findAll();
        
        $this->addElement(new Zend_Form_Element_Text('Nazwa_testu', 
                array(
                    'label' => 'Nazwa testu',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'require' => true
                )));
        
        $this->addElement(new Zend_Form_Element_Text('data_od', 
                array(
                    'label' => 'Data rozpoczecia dostępności testu',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'require' => true
                )));
        
        $this->addElement(new Zend_Form_Element_Text('data_do', 
                array(
                    'label' => 'Data zakończenie dostępności testu',
                    'validators' => array(
                                'NotEmpty'
                            ),
                    'require' => false
                )));
        
        foreach ($zadania as $zadanie) {
        $this->addElement(new Zend_Form_Element_Checkbox('zadanie_'.$zadanie->idZadania, 
                array(
                    'label' => $zadanie->tresc,
                )));
        }
        
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
        
        $this->addElement('submit', 'Zapisz', array(
            'label' => 'Zapisz',
            'required' => true
        ));
    }

}


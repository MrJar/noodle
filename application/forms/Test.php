<?php

class Application_Form_Test extends Zend_Form
{

    private $_idTest = null;
    /**
     * @desc Formularz testu który rozwiazuje uczen.
     */
    public function __construct($options = null) {
        $this->_idTest = $options;
        parent::__construct();
    }
    
    
    public function init()
    {
        $this->setAction('/tests/save/?id='.$this->_idTest)->setMethod('post');
        $this->setName('testForm');
        
        $listaZadan = Application_Model_TestyHas_ZadaniaTable::getInstance()->findByTesty_idTesty($this->_idTest);
        
        foreach ($listaZadan as $zadanie) {
            $zadanieBaza = Application_Model_ZadaniaTable::getInstance()->getZadanie($zadanie->Zadania_idZadania);
            
            $zadanieFormElement = new Zend_Form_Element_Textarea('zadanie_'.$zadanieBaza->idZadania);
            $zadanieFormElement->setLabel("Ptyanie: ".$zadanieBaza->tresc . " Punkty: " . $zadanieBaza->punkty);
            $zadanieFormElement->setRequired();
            $zadanieFormElement->setAttrib('cols', '80');
            $zadanieFormElement->setAttrib('rows', '10');
            $this->addElement($zadanieFormElement);
            unset($zadanieBaza);
        }
        
        $this->addElement(new Zend_Form_Element_Submit('zapisz_test', 
                array(
                    'label' => 'Zapisz test',
                    'require' => true
                )));
    }


}


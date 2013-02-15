<?php

class Application_Form_GenTest extends Zend_Form {


   /* 
    public function __construct($options = null) {
        parent::__construct($options);
        
        if (isset($options['przedmiot'])) {

            self::$przedmiot = (int)$options['przedmiot'];
            var_dump(self::$przedmiot);
        }
        if (isset($options['ileZadan'])) {
            self::$ileZadan = (int)$options['ileZadan'];
        }
        
        
    }

*/
    public function init() {
        //$this->setAction('/tests/add')->setMethod('post');
        
        $this->setAttrib('id', 'genTest');

        $zadania_mdl = Application_Model_ZadaniaTable::getInstance();
        
        $this->addElement(new Zend_Form_Element_Text('Nazwa_testu', 
                array(
                    'label' => 'Nazwa testu',
                    'require' => true
                )));
        
        $this->addElement(new Zend_Form_Element_Text('data_od', 
                array(
                    'label' => 'Data rozpoczecia dostępności testu',
                    'require' => true
                )));
        
        $this->addElement(new Zend_Form_Element_Text('data_do', 
                array(
                    'label' => 'Data zakończenie dostępności testu',
                    'require' => false
                )));
        
        $przedmioty = Application_Model_PrzedmiotyTable::getInstance()->findAll()->toArray();
        
        $przedAdd = array(0 => '--wybierz--');
        foreach ($przedmioty as $przedmiot) {
            $przedAdd[$przedmiot['idPrzedmioty']] = $przedmiot['nazwa'];
        }
        
        $this->addElement(new Zend_Form_Element_Select('Przedmioty_idPrzedmioty',
                        array(
                            'label' => 'Przedmiot',
                            'multiOptions' => $przedAdd,
                            'required' => true
                )));
        //$przedmiot = $this->getElement('Przedmioty_idPrzedmioty')->getValue();
        
        if ($this->getAttrib('przedmiot') > 0) {
            $countZadania =  $zadania_mdl->getZadania(array('Przedmioty_idPrzedmioty = ?',$przedmiot), TRUE);
        }
//        var_dump($countZadania);
      //die(); 
        if (isset($countZadania)) {
            for($i=0;$i<=$countZadania;$i++) {
                $ile[$i]=$i;
            }
        

            $iloscElement = new Zend_Form_Element_Select('ilosc', 
                      array(
                          'label' => 'Ilosc pytan',
                          'require' => true,
                          'multiOptions' => $ile
                      ));

            if ($this->getAttrib('przedmiot') > 0) {
                $this->addElement($iloscElement);
                //$ilosc = (int)$this->getElement('ilosc')->getValue();
            }

            //$przedmiot = (int)$this->getElement('Przedmioty_idPrzedmioty')->getValue();
            /*if ($this->getAttrib('ileZadan') > 0) {
                $zadania = $zadania_mdl->getRandom($this->getAttrib('przedmiot'),$this->getAttrib('ileZadan') );
                foreach ($zadania as $zadanie) {
                    
                    $this->addElement(new Zend_Form_Element_Checkbox($zadanie['idZadania'], 
                            array(
                                'label' => $zadanie['tresc'],
                                'belongsTo' => 'zadania'
                            )));
                }
            }*/
        }
        //die();
        
        
        
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Zapisz');
        if ($this->getAttrib('ileZadan') > 0 && $this->getAttrib('przedmiot') > 0) {
            $this->addElement('submit', 'Zapisz', array(
                'label' => 'Zapisz',
                'required' => true
            ));
            
            $this->getElement('Nazwa_testu')->setRequired(true);

        }
    }

}


<?php

class Application_Form_GenTest extends Zend_Form {


    public function init() {
 
        
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
    
        
        if ($this->getAttrib('przedmiot') > 0) {
            $countZadania =  $zadania_mdl->getZadania(array('Przedmioty_idPrzedmioty = ?',$przedmiot), TRUE);
        }
 
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

            }
        }
        
        
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


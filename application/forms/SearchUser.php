<?php

class Application_Form_SearchUser extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */

        $this->setAction('/users/search')->setMethod('post');

        $radio = new Zend_Form_Element_Radio('search');
        $radio->setLabel('Szukaj po : ')
              ->addMultiOptions(array(
            'login' => 'login',
            'grupa' => 'grupa',
            'rola' => 'rola'
        
        ))->setValue('login');
        $this->addElement($radio);
        


        $this->addElement(new Zend_Form_Element_Text('param',
                        array(
                            'label' => 'Szukaj',
                            'required' => true
                )));
        
       


        $this->addElement('submit', 'Szukaj', array(
            'label' => 'Szukaj',
            'required' => true
        ));
    }

}
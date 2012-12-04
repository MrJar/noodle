<?php

class Noodle_Ideone_Api_Base {
    
    const NO = 0;
    const YES = 1;

    private $_user = null;
    private $_password = null;
    
    private $_location = null;
    private $_uri = null;
    
    const WRONG_LANG_ID = 1;

    public function __construct($configuration) {
        $this->_user = $configuration->user;
        $this->_password = $configuration->password;
        $this->_location = $configuration->location;
        $this->_uri = $configuration->uri;
    }
    
    public function getListOfMethod() {
        
        $list = array(
            'createSubmission' => self::NO,
            'getSubmissionStatus' => self::NO,
            'getSubmissionDetails' => self::NO,
            'getLanguages' => self::YES,
            'testFunction' => self::YES,
        );
        
        return $list;
    }
    
    protected function _call($name,array $arguments = null) {
        
        $client = new Zend_Soap_Client(null, array(
            'location' => $this->_location,
            'uri'      => $this->_uri
        ));
        
        $argumentsBase = array(
                    $this->_user,
                    $this->_password,
                    );
        
        if (!is_null($arguments)) {
            $argumentsMerged = array_merge($argumentsBase, $arguments);
        }
        
        try {
            $result = $client->__call(
                $name,
                $argumentsMerged
            );
            
            return $result;
            
        } catch (SoapFault $s) {
            die('ERROR: [' . $s->faultcode . '] ' . $s->faultstring);
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }
    
}
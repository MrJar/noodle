<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Api
 *
 * @author Jan
 */
class Noodle_Ideone_Api extends Noodle_Ideone_Api_Base {
    
    public function __construct() {
        $config = Zend_Registry::get('config');
        
        foreach ($config->api->ideone as $key => $value) {
            if (!isset($value) || $value == '') {
                throw new Exception('Wrong configuration');
            }
        }

        parent::__construct($config->api->ideone);
    }
    
    /**
     * 
     * @param string $sourceCode
     * @param integer $language
     * @param string $input
     * @param boolean $run
     * @param boolean $private
     * @return type
     */
    public function createSubmission($sourceCode, $language, $input, $run, $private) {
        $arguments = array(
            $sourceCode,
            $language,
            $input,
            $run,
            $private
        );
        
        return $this->_call('createSubmission', $arguments);
    }
    
    public function getSubmissionStatus($link) {
        $arguments = array(
            $link
        );
        
        return $this->_call('getSubmissionStatus', $arguments);
    }
    
    /**
     * 
     * @param string $link
     * @param boolean $withSource
     * @param boolean $withInput
     * @param boolean $withOutput
     * @param boolean $withStderr
     * @param boolean $withCmpinfo
     * @return type
     */
    public function getSubmissionDetails($link, $withSource, $withInput, $withOutput, $withStderr, $withCmpinfo) {
        $arguments = array(
            $link,
            $withSource,
            $withInput,
            $withOutput,
            $withStderr,
            $withCmpinfo
        );
        
        return $this->_call('getSubmissionDetails', $arguments);
    }
    
    /**
     * 
     * @return type
     */
    public function getLanguages() {
        return $this->_call('getLanguages');
    }
    
    /**
     * 
     * @return type
     */
    public function testFunction() {
        return $this->_call('testFunction');
    }
    
}

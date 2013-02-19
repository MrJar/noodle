<?php

class Noodle_Validate_NotEmpty extends Zend_Validate_NotEmpty
{

    const INVALID  = 'notEmptyInvalid';
    const IS_EMPTY = 'isEmpty';


    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::IS_EMPTY => "Wartość jest wymagana i nie może być pusta",
        self::INVALID  => "Invalid type given. String, integer, float, boolean or array expected",
    );
}

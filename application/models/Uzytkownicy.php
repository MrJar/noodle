<?php

/**
 * Application_Model_Uzytkownicy
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Application_Model_Uzytkownicy extends Application_Model_Base_Uzytkownicy
{
    const ROLE_STUDENT = '1';
    const ROLE_LECTURER = '2';
    const ROLE_ADMIN = '3';
    
    public $role = array (
        self::ROLE_STUDENT => 'Student',
        self::ROLE_LECTURER => 'Wykładowca',
        self::ROLE_ADMIN => 'Admin',
    );
    
    
//    
//    	public function nowyUzytkownik()
//	{
//	$params = $this->_getAllParams();
//        $uzytkownik = new Application_Model_Uzytkownicy();
//        $uzytkownik->login = $params['login'];
//        $uzytkownik->haslo = sha1($params['haslo']);
//
//        $uzytkownik->email = $params['email'];
//        $uzytkownik->rola = $params['rola'];
//        $uzytkownik->Grupy_idGrupy = $params['Grupy_idGrupy'];
//        $uzytkownik->save();
//	    return TRUE;
//	} 
	
}
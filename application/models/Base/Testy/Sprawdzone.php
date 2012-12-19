<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Application_Model_Testy_Sprawdzone', 'doctrine');

/**
 * Application_Model_Base_Testy_Sprawdzone
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idTesty_Sprawdzone
 * @property integer $zdobyte_punkty
 * @property integer $Uzytkownicy_idUzytkownicy
 * @property Application_Model_Uzytkownicy $Uzytkownicy
 * @property Application_Model_Testy $Testy
 * @property Doctrine_Collection $RozwiazanieZadania
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Application_Model_Base_Testy_Sprawdzone extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('Testy_Sprawdzone');
        $this->hasColumn('idTesty_Sprawdzone', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('zdobyte_punkty', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('Uzytkownicy_idUzytkownicy', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Application_Model_Uzytkownicy as Uzytkownicy', array(
             'local' => 'Uzytkownicy_idUzytkownicy',
             'foreign' => 'idUzytkownicy'));

        $this->hasOne('Application_Model_Testy as Testy', array(
             'local' => 'idTesty_Sprawdzone',
             'foreign' => 'idTesty'));

        $this->hasMany('Application_Model_RozwiazanieZadania as RozwiazanieZadania', array(
             'local' => 'idTesty_Sprawdzone',
             'foreign' => 'Testy_Sprawdzone_idTesty_Sprawdzone'));
    }
}
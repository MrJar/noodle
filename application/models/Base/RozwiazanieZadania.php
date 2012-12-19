<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Application_Model_RozwiazanieZadania', 'doctrine');

/**
 * Application_Model_Base_RozwiazanieZadania
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idZadania
 * @property integer $idU?ytkownicy
 * @property string $rozwiazanie
 * @property string $zdobyte_pkt
 * @property integer $Uzytkownicy_idUzytkownicy
 * @property integer $Testy_Sprawdzone_idTesty_Sprawdzone
 * @property Application_Model_Uzytkownicy $Uzytkownicy
 * @property Application_Model_Testy_Sprawdzone $Testy_Sprawdzone
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Application_Model_Base_RozwiazanieZadania extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('Rozwiazanie_zadania');
        $this->hasColumn('idZadania', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('idU?ytkownicy', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('rozwiazanie', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('zdobyte_pkt', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
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
        $this->hasColumn('Testy_Sprawdzone_idTesty_Sprawdzone', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Application_Model_Uzytkownicy as Uzytkownicy', array(
             'local' => 'Uzytkownicy_idUzytkownicy',
             'foreign' => 'idUzytkownicy'));

        $this->hasOne('Application_Model_Testy_Sprawdzone as Testy_Sprawdzone', array(
             'local' => 'Testy_Sprawdzone_idTesty_Sprawdzone',
             'foreign' => 'idTesty_Sprawdzone'));
    }
}
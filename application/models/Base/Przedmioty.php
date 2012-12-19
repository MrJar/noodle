<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Application_Model_Przedmioty', 'doctrine');

/**
 * Application_Model_Base_Przedmioty
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idPrzedmioty
 * @property string $nazwa
 * @property string $kierunek
 * @property string $grupa
 * @property integer $Uzytkownicy_idUzytkownicy
 * @property integer $Testy_idTesty
 * @property Application_Model_Testy $Testy
 * @property Doctrine_Collection $Zadania
 * @property Doctrine_Collection $Zadania_2
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Application_Model_Base_Przedmioty extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('Przedmioty');
        $this->hasColumn('idPrzedmioty', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('nazwa', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('kierunek', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('grupa', 'string', 45, array(
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
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('Testy_idTesty', 'integer', 4, array(
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
        $this->hasOne('Application_Model_Testy as Testy', array(
             'local' => 'Testy_idTesty',
             'foreign' => 'idTesty'));

        $this->hasMany('Application_Model_Zadania as Zadania', array(
             'local' => 'idPrzedmioty',
             'foreign' => 'Przedmioty_idPrzedmioty1'));

        $this->hasMany('Application_Model_Zadania as Zadania_2', array(
             'local' => 'Uzytkownicy_idUzytkownicy',
             'foreign' => 'Przedmioty_Uzytkownicy_idUzytkownicy'));
    }
}
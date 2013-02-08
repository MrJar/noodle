<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Application_Model_Zadania', 'doctrine');

/**
 * Application_Model_Base_Zadania
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idZadania
 * @property string $typ
 * @property string $tresc
 * @property string $rozwiazanie
 * @property string $danetestowe
 * @property string $wyniki
 * @property integer $status
 * @property integer $punkty
 * @property integer $poziomtrudnosci
 * @property integer $Przedmioty_idPrzedmioty
 * @property Application_Model_Przedmioty $Przedmioty
 * @property Doctrine_Collection $TestyHas_Zadania
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Application_Model_Base_Zadania extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('Zadania');
        $this->hasColumn('idZadania', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('typ', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('tresc', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
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
        $this->hasColumn('danetestowe', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('wyniki', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('status', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('punkty', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('poziomtrudnosci', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('Przedmioty_idPrzedmioty', 'integer', 4, array(
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
        $this->hasOne('Application_Model_Przedmioty as Przedmioty', array(
             'local' => 'Przedmioty_idPrzedmioty',
             'foreign' => 'idPrzedmioty'));

        $this->hasMany('Application_Model_TestyHas_Zadania as TestyHas_Zadania', array(
             'local' => 'idZadania',
             'foreign' => 'Zadania_idZadania'));
    }
}
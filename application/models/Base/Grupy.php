<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Application_Model_Grupy', 'doctrine');

/**
 * Application_Model_Base_Grupy
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idGrupy
 * @property string $kierunek
 * @property string $nazwa
 * @property Doctrine_Collection $Uzytkownicy
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Application_Model_Base_Grupy extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('Grupy');
        $this->hasColumn('idGrupy', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
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
        $this->hasColumn('nazwa', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
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
        $this->hasMany('Application_Model_Uzytkownicy as Uzytkownicy', array(
             'local' => 'idGrupy',
             'foreign' => 'Grupy_idGrupy'));
    }
}
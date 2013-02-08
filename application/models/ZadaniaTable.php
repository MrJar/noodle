<?php

/**
 * Application_Model_ZadaniaTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Application_Model_ZadaniaTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Application_Model_ZadaniaTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Application_Model_Zadania');
    }
    
    public function getZadanie($idZadania)
    {
        $query = Doctrine_Query::create()
                ->from('Application_Model_Zadania as Zadania')
                ->where('idZadania = ?', $idZadania);
        
        return $query->fetchOne();
    }
    
    /**
     * 
     * @param int $przedmiot
     * @param int $limit
     */
    public function getRandom($przedmiot, $limit)
    {
        $query = Doctrine_Query::create()
                ->from('Application_Model_Zadania as Zadania')
                ->where('Przedmioty_idPrzedmioty = ?', $przedmiot)
                ->orderBy('RAND()')
                ->limit($limit);
        
        return $query->fetchArray();
    }
    
    /**
     * $where = array(
     *      'kolumna = ?' => 'warunek'
     * )
     * @param type $where
     */
    public function getZadania($where = array(), $count = false)
    {
        if ($count) {
            $query = Doctrine_Query::create()
                    ->select('COUNT(*)')
                    ->from('Application_Model_Zadania as Zadania');
        }
        else {
            $query = Doctrine_Query::create()
                    ->from('Application_Model_Zadania as Zadania');
        }
        
        if(!empty($where)) {
            foreach ($where as $col => $cond) {
                $query->where($col, $cond);
            }
        }

        
        if ($count) {
            $result = $query->fetchArray();
            return $result[0]['COUNT'];
        }
        else {
            return $query->fetchArray();
        }
    }
}   
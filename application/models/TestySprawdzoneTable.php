<?php

/**
 * Application_Model_ZadaniaTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Application_Model_TestySprawdzoneTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Application_Model_ZadaniaTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Application_Model_TestySprawdzone');
    }
    
  
    /**
     * $where = array(
     *      'kolumna = ?' => 'warunek'
     * )
     * @param type $where
     */
    public function getTesty($where = array())
    {
      
        $query = Doctrine_Query::create()                    
                ->from('Application_Model_TestySprawdzone as Testy_Sprawdzone');
                //->innerJoin('Testy_Sprawdzone.Testy_idTesty as idTesty');
      
        
        if(!empty($where)) {
            foreach ($where as $col => $cond) {
                $query->where($col, $cond);
            }
        }

        return $query->fetchArray();

    }
}   
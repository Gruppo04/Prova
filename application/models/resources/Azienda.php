<?php

class Application_Resource_Azienda extends Zend_Db_Table_Abstract
{
    protected $_name	 = 'aziende';
    protected $_primary	 = 'id';
    protected $_rowClass = 'Application_Resource_Azienda_Item';
    
    public function init()
    {
    }
    
    public function getAziende()
    {
        $select = $this->select()
                        ->where('id = 1');
        return $this ->fetchAll($select);        
    }
}

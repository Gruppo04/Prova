<?php

class Application_Resource_Azienda extends Zend_Db_Table_Abstract
{
    protected $_name	 = 'nome';
    protected $_primary	 = 'id';
    protected $_rowClass = 'Application_Resource_Azienda_Item';
    
    public function init()
    {
    }
    
    public function getAzById($id)
    {
        return $this->find($id)->current();
    }
}

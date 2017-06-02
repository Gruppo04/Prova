<?php

class Application_Resource_Categorie extends Zend_Db_Table_Abstract
{
    protected $_name	 = 'categorie';
    protected $_primary	 = 'id';
    protected $_rowClass = 'Application_Resource_Categorie_Item';
    
    public function init()
    {
    }
    
    public function getCategorie()
    {
        $select = $this->select();
        return $this ->fetchAll($select);
    }
    
    public function registraCategoria($info)
    {
        return $this ->insert($info);
    }
    
    
}

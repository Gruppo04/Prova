<?php

class Application_Resource_Categoria extends Zend_Db_Table_Abstract	// viene bypassata la cartella Models perchè così è stato detto all'Autoloader
{
    protected $_name	 = 'categorie';
    protected $_primary	 = 'id';
    protected $_rowClass = 'Application_Resource_Categoria_Item';
    
    public function init()
    {
    }
    
    public function getCategorie()
    {
        $select = $this->select();
        return $this ->fetchAll($select);
    }
}

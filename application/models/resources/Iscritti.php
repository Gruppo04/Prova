<?php

class Application_Resource_Iscritti extends Zend_Db_Table_Abstract	// viene bypassata la cartella Models perchè così è stato detto all'Autoloader
{
    protected $_name	 = 'utenti';
    protected $_primary	 = 'id';
    protected $_rowClass = 'Application_Resource_Iscritti_Item';
    
    public function init()
    {
    }
    
    public function registraUtente($info)
    {
        return $this->insert($info);
    }
}

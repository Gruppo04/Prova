<?php

class Application_Resource_Credenziali extends Zend_Db_Table_Abstract	// viene bypassata la cartella Models perchè così è stato detto all'Autoloader
{
    protected $_name	 = 'credenziali';
    protected $_primary	 = 'username';
    protected $_rowClass = 'Application_Resource_Credenziali_Item';
    
    public function init()
    {
    }
    
    public function registraCredenziali($info)
    {
        return $this->insert($info);
    }
}

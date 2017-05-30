<?php

class Application_Resource_Utenti extends Zend_Db_Table_Abstract	// viene bypassata la cartella Models perchè così è stato detto all'Autoloader
{
    protected $_name	 = 'utenti';
    protected $_primary	 = 'id';
    protected $_rowClass = 'Application_Resource_Utenti_Item';
    
    public function init()
    {
    }
    
    public function registraUser($info)
    {
        return $this->insert($info);
    }
    
    public function getUtenteByNome($username)
    {
        return $this->fetchRow($this->select()->where('username = ?', $username));
    }
}

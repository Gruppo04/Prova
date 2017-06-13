<?php

class Application_Resource_Utenti extends Zend_Db_Table_Abstract
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
    
    public function getUsers()
    {
        $select = $this->select()->where('livello = ?', 'user')->order('id');
        return $this->fetchAll($select);
    }
        
    public function getStaff()
    {
        $select = $this->select()->where('livello = ?', 'staff')->order('id');
        return $this->fetchAll($select);
    }
    
    public function registraStaff($info)
    {
        return $this->insert($info);
    }
    
    public function getUtenteByUsername($info)
    {
        $select = $this->select()->where('username = ?', $info);
        return $this->fetchRow($select);
    }
    
    public function getUtenteById($id)
    {
        $select = $this->select()->where('id = ?', $id);
        return $this->fetchRow($select);
    }
    
    public function delUtente($id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->delete($where);
    }
    
    public function modificaDati($info, $id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($info, $where);
    }
    
    public function modificaPassword($info, $id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($info, $where);
    }
}

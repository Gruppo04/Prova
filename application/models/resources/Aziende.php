<?php

class Application_Resource_Aziende extends Zend_Db_Table_Abstract
{
    protected $_name	 = 'aziende';
    protected $_primary	 = 'id';
    protected $_rowClass = 'Application_Resource_Aziende_Item';
    
    public function init()
    {
    }
    
    public function getAziende()
    {
        $select = $this->select();
        return $this ->fetchAll($select);        
    }
    
    public function getAziendaById($id)
    {
        $select = $this->select()->where('id = ?', $id);
        return $this->fetchRow($select);        
    }
    
    public function delAzienda($id)
    {
        //$where = $this->quoteInto('id = ?', $id);
        return $this->delete($this->_name, "id = $id");
    }
    
    public function registraAzienda($info)
    {
        return $this ->insert($info);
    }
    
    public function modificaAzienda($info, $id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($info, $where);
    }
}

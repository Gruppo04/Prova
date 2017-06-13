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
    
    public function getAziendeByCoupon_Emessi()
    {
        $select = $this->select()->order('tot_emissioni DESC');
        return $this ->fetchAll($select);        
    }
    
    public function getAziendaById($id)
    {
        $select = $this->select()->where('id = ?', $id);
        return $this->fetchRow($select);        
    }
    
    public function getAziendaByNome($nome)
    {
        $select = $this->select()->where('nome = ?', $nome);
        return $this->fetchRow($select);       
    }
    
    public function delAzienda($id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->delete($where);
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
    
    public function incrementaAzienda($value, $id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($value, $where);
    }
}

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
    
    public function getCategorieByTot_Emissioni()
    {
        $select = $this->select()->order('tot_emissioni DESC');
        return $this ->fetchAll($select);        
    }
    
    public function getCategoriaById($id)
    {
        $select = $this->select()->where('id = ?', $id);
        return $this->fetchRow($select);        
    }
    
    public function getCategoriaByNome($nome)
    {
        $select = $this->select()->where('nome = ?', $nome);
        return $this->fetchRow($select);        
    }
    
    public function registraCategoria($info)
    {
        return $this ->insert($info);
    }
    
    public function modificaCategoria($info, $id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($info, $where);
    }
    
    public function delCategoria($id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->delete($where);
    }
    
    public function getRicercaByCat($textbox)
    {
       $select = $this->select()->where('descrizione LIKE ?',$textbox.'%')
                                ->ORwhere('nome LIKE ?', '%'.$textbox.'%');
       return $this ->fetchAll($select);
    }
    
    public function incrementaCategoria($value, $id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($value, $where);
    }
}

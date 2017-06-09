<?php

class Application_Resource_Faq extends Zend_Db_Table_Abstract
{
    protected $_name	 = 'faq';
    protected $_primary	 = 'id';
    protected $_rowClass = 'Application_Resource_Faq_Item';
    
    public function init()
    {
    }
    
    public function getFaq()
    {
        $select = $this->select();
        return $this ->fetchAll($select);        
    }
    
    public function getFaqById($id)
    {
        $select = $this->select()->where('id = ?', $id);
        return $this->fetchRow($select);       
    }
    
    public function registraFaq($info)
    {
        return $this ->insert($info);        
    }
    
    public function delFaq($id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->delete($where);
    }
    
    public function modificaFaq($info, $id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($info, $where);
    }
}

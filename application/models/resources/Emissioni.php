<?php

class Application_Resource_Emissioni extends Zend_Db_Table_Abstract
{
    protected $_name	 = 'cronologia_coupon';
    protected $_primary	 = 'id';
    protected $_rowClass = 'Application_Resource_Emissioni_Item';
    
    public function init()
    {
    }
    
    public function registraEmissione($info)
    {
        return $this ->insert($info);
    }
    
    public function getEmissioneById($id)
    {
        $select = $this->select()->where('id = ?', $id);
        return $this->fetchRow($select);
    }
}

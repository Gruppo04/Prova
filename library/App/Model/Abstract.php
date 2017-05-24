<?php

abstract class App_Model_Abstract	// è una classe di classi
{	
    protected $_resources = array();
	
    public function getResource($name) 
    {
        if (!isset($this->_resources[$name]))
        {   // controlla se c'è già un oggetto associato a quella classe
            $class = implode('_', array(    // crea una stringa da elementi di un array separandoli con '_', per creare il path nel nome
                                $this->_getNamespace(),
                                'Resource',
                                $name));                    
            $this->_resources[$name] = new $class();
        }
        return $this->_resources[$name];
    }

    private function _getNamespace()
    {
        $ns = explode('_', get_class($this));
        return $ns[0];
    }

}
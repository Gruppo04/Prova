<?php

class PublicController extends Zend_Controller_Action
{
    protected $_catalogoModel;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
        $this->_catalogoModel = new Application_Model_Catalogo();
    }
    
    public function indexAction()
    {
    }
    
    public function aziendeAction()
    {
        $az=$this->_catalogoModel->getAziende();
        $this->view->assign(array('aziende' => $az));
    }
    
    public function viewstaticAction()
    {
    	$page = $this->_getParam('staticPage');
    	$this->render($page);
    }
}
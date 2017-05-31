<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap	// extends definisce la superclasse da cui questa eredita le caratteristiche (che è un path)
{
    protected  $_view;
    
    protected function _initRequest()
    // Aggiunge un'istanza di Zend_Controller_Request_Http nel Front_Controller
    // che permette di utilizzare l'helper baseUrl() nel Bootstrap.php
    // Necessario solo se la Document-root di Apache non è la cartella public/
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }
    
    
    protected function _initViewSettings()
    {
        $this->bootstrap('view');
        $this->_view = $this->getResource('view');
        $this->_view->headMeta()->setCharset('UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'it-IT');
        // In questo modo si condivide il foglio di stile
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/cssBootstrap/bootstrap.min.css'));
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/cssBootstrap/modern-business.css'));
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/font-awesome/css/font-awesome.min.css'));
        $this->_view->headScript()->appendFile($this->_view->baseUrl('js/jquery.js'));
        $this->_view->headScript()->appendFile($this->_view->baseUrl('js/bootstrap.min.js'));
        $this->_view->headTitle('Coupon Is Life');
    }
    
    protected function _initDefaultModuleAutoloader()
    {
    	$loader = Zend_Loader_Autoloader::getInstance();
	$loader->registerNamespace('App_');
        $this->getResourceLoader()
             ->addResourceType('modelResource','models/resources','Resource');
    }
    
    protected function _initDbParms()
    {
    	include_once (APPLICATION_PATH . '/../include/connectZP.php');
	$db = new Zend_Db_Adapter_Pdo_Mysql(array(
    			'host'     => $HOST,
    			'username' => $USER,
    			'password' => $PASSWORD,
    			'dbname'   => $DB));  
	Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }
}


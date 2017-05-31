<?php

class Application_Service_Auth
{
    protected $_utentiModel;
    protected $_auth;

    public function __construct()
    {
        $this->_utentiModel = new Application_Model_Utenti();
    }
    
    public function authenticate($credenziali)
    {
        $adapter = $this->getAuthAdapter($credenziali);
        $auth    = $this->getAuth();
        $result  = $auth->authenticate($adapter);

        if (!$result->isValid()) {
            return false;
        }
        $utente = $this->_utentiModel->getUtenteByNome($credenziali['username']);
        $auth->getStorage()->write($utente);
        return true;
    }
    
    public function getAuth()
    {
        if (null === $this->_auth) {
            $this->_auth = Zend_Auth::getInstance();
        }
        return $this->_auth;
    }
   
    public function getIdentity()
    {
        $auth = $this->getAuth();
        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }
        return false;
    }
    
    public function clear()
    {
        $this->getAuth()->clearIdentity();
    }
    
    private function getAuthAdapter($values)
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable(
                Zend_Db_Table_Abstract::getDefaultAdapter(),
                'utenti',
                'username',
                'password');
        $authAdapter->setIdentity($values['username']);
        $authAdapter->setCredential($values['password']);
        return $authAdapter;
    }
}

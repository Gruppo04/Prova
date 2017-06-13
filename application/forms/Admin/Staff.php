<?php

class Application_Form_Admin_Staff extends Zend_Form
{       
    
    public function init() {
        
        $this->setMethod('post');
        $this->setName('registrazione staff');
        $this->setAction('');
        
        // La seguente istruzione permette di usare i filtri custom
        $this->addElementPrefixPath('Filter', APPLICATION_PATH . '/../library/Filter', 'filter');
        
        // Validatore per controllare se il nome staff esiste già
        $esiste = new Zend_Validate_Db_NoRecordExists(
                array(
                    'adapter'=> Zend_Db_Table_Abstract::getDefaultAdapter(),
                    'table' => 'utenti',
                    'field' => 'nome'
                    ));
        $esiste->setMessage('Username already exists');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        $this->getElement('nome')->addFilter(new Filter_Uc);
        
        $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        $this->getElement('cognome')->addFilter(new Filter_Uc);
        
        $this->addElement('text', 'email', array(
            'label' => 'Indirizzo e-mail',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress')));
        
        $this->addElement('text', 'username', array(
            'label' => 'Scegli un nome utente',
            'required' => 'true',
            'filters' => array('StringTrim')));
        $this->getElement('username')->addValidator($esiste);
        
        $this->addElement('password', 'password', array(
            'label' => 'Scegli una password',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(4,25)))));
        
        $this->addElement('password', 'verificapassword', array(
                'label'      => 'Conferma password',
                'required'   => true,
                'validators' => array(
                    array('Identical', false, array('token' => 'password'))
                    )));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Inserisci membro staff',
            'class' => 'btn btn-primary'));
    }

}

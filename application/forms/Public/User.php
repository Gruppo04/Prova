<?php

class Application_Form_Public_User extends Zend_Form
{
    public function init() {
        
        $this->setMethod('post');
        $this->setName('registrazione');
        $this->setAction('');
        
        // La seguente istruzione permette di usare i filtri custom
        $this->addElementPrefixPath('Filter', APPLICATION_PATH . '/../library/Filter', 'filter');
        
        /* validatori per controllare se lo username e l'email sono già usati
         * da qualcun'altro
         */
        $esiste = new Zend_Validate_Db_NoRecordExists(
                array(
                    'adapter'=> Zend_Db_Table_Abstract::getDefaultAdapter(),
                    'table' => 'utenti',
                    'field' => 'username'
                    ));
        $esiste->setMessage('Username already exists, choose another one');
        $esisteMail = new Zend_Validate_Db_NoRecordExists(
                array(
                    'adapter'=> Zend_Db_Table_Abstract::getDefaultAdapter(),
                    'table' => 'utenti',
                    'field' => 'email'
                    ));
        $esisteMail->setMessage('Email address already exists');
        
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
        
        $this->addElement('text', 'data_di_nascita', array(
            'label' => 'Data di nascita',
            'required' => 'true',
            'placeholder' => 'aaaa-mm-gg',
            'filters' => array('StringTrim'),
            'validators' => array('Date')
            ));
        
        $this->addElement('radio', 'genere', array(
            'MultiOptions' => array('M' => 'Maschio', 'F' => 'Femmina'),
            'value' => 'M',
            'required' => 'true'));
        
        $this->addElement('text', 'provincia', array(
            'label' => 'Provincia',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        
        $this->addElement('text', 'citta', array(
            'label' => 'Comune',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        $this->getElement('citta')->addFilter(new Filter_Uc);
        
        $this->addElement('text', 'telefono', array(
            'label' => 'Numero di telefono',
            'placeholder' => '(facoltativo)',
            'value' => null,
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(9,10)),
                'Digits')));
        
        $this->addElement('text', 'email', array(
            'label' => 'Indirizzo e-mail',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress')));
        $this->getElement('email')->addValidator($esisteMail);
        
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
            'label' => 'Registrati',
            'class' => 'btn btn-primary'));
    }

}

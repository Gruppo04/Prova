<?php

class Application_Form_Admin_UserMod extends App_Form_Abstract
{       
    
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica utente');
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
        $esiste->setMessage('Username already exists');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        $this->getElement('nome')->addFilter(new Filter_Uc);
        
        $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        $this->getElement('cognome')->addFilter(new Filter_Uc);
        
        $this->addElement('text', 'data_di_nascita', array(
            'label' => 'Data di nascita',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'placeholder' => 'aaaa-mm-gg',
            'filters' => array('StringTrim'),
            'validators' => array('Date')
            ));
        
        $this->getElement('data_di_nascita')->addValidator(new Validator_DataReg());
        
        $this->addElement('radio', 'genere', array(
            'MultiOptions' => array('M' => 'Maschio', 'F' => 'Femmina'),
            'value' => 'M',
            'required' => 'true',
            'decorators' => $this->elementDecorators
                ));
        
        $this->addElement('text', 'provincia', array(
            'label' => 'Provincia',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        
        $this->addElement('text', 'citta', array(
            'label' => 'Comune',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
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
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress')));
        
        $this->addElement('text', 'nuovo_username', array(
            'label' => 'Nome utente',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim')));
        $this->getElement('nuovo_username')->addValidator($esiste);
        
        $this->addElement('hidden', 'username');
        
        $this->addElement('text', 'password', array(
            'label' => 'Password',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(4,25)))));

        $this->addElement('hidden', 'idModifica',array(
            'required' => true
        ));
        
        $this->addElement('submit', 'modifica', array(
            'label' => 'Applica modifiche',
            'class' => 'btn btn-primary'));
        
        $this->addElement('submit', 'cancella', array(
            'label' => 'Cancella utente',
            'class' => 'btn btn-danger',
            'style' => 'position: relative; left: 150px; bottom: 54px'));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'zend_form')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }

}

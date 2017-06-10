<?php

class Application_Form_Admin_Categoria extends Zend_Form
{
    public function init() {
        
        $this->setMethod('post');
        $this->setName('registrazione categoria');
        $this->setAction('');
        
        // La seguente istruzione permette di usare i filtri custom
        $this->addElementPrefixPath('Filter', APPLICATION_PATH . '/../library/Filter', 'filter');
        
        // Validatore per controllare se il nome categoria esiste già
        $esiste = new Zend_Validate_Db_NoRecordExists(
                array(
                    'adapter'=> Zend_Db_Table_Abstract::getDefaultAdapter(),
                    'table' => 'categorie',
                    'field' => 'nome'
                    ));
        $esiste->setMessage('Categoria già esistente');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true))
            )));
        $this->getElement('nome')->addFilter(new Filter_Uc);
        $this->getElement('nome')->addValidator($esiste);
        
        $this->addElement('textarea', 'descrizione', array(
            'label' => 'Descrizione',
        	'cols' => '50', 'rows' => '5',
            'filters' => array('StringTrim'),
            'required' => true,
            'autofocus'  => true,
            'placeholder' => 'Inserisci una descrizione della categoria',
            'validators' => array(array('StringLength',true, array(1,1000)))
        ));
        
        $this->addElement('file', 'immagine', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images/categorie',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 204800),
        			array('Extension', false, array('jpg', 'gif', 'png', 'bmp')))));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Inserisci categoria',
            'class' => 'btn btn-primary'));
    }

}
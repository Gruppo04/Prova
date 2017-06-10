<?php

class Application_Form_Admin_Azienda extends Zend_Form
{
    
    public function init() {
        
        $this->setMethod('post');
        $this->setName('registrazione azienda');
        $this->setAction('');
        
        // La seguente istruzione permette di usare i filtri custom
        $this->addElementPrefixPath('Filter', APPLICATION_PATH . '/../library/Filter', 'filter');
        
        // Validatore per controllare se il nome azienda esiste già
        $esiste = new Zend_Validate_Db_NoRecordExists(
                array(
                    'adapter'=> Zend_Db_Table_Abstract::getDefaultAdapter(),
                    'table' => 'aziende',
                    'field' => 'nome'
                    ));
        $esiste->setMessage('Azienda già esistente');
   
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        $this->getElement('nome')->addFilter(new Filter_Uc);
        $this->getElement('nome')->addValidator($esiste);
        
        $this->addElement('textarea', 'descrizione', array(
            'label' => 'Descrizione',
        	'cols' => '50', 'rows' => '5',
            'filters' => array('StringTrim'),
            'required' => true,
            'autofocus'  => true,
            'placeholder' => 'Inserisci una descrizione dell\'azienda',
            'validators' => array(
                array('StringLength',true, array(1,1000)))
        ));
        
        $this->addElement('text', 'ragione_sociale', array(
            'label' => 'Ragione sociale',
            'required' => 'true',
            'filters' => array('StringTrim')
            ));
        
        $this->addElement('text', 'localizzazione', array(
            'label' => 'Localizzazione',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        
        $this->addElement('select', 'tipologia', array(
            'label' => 'Tipologia',
            'value' => '',
            'required' => true,
            'multiOptions' => array(
                ''          => 'Seleziona',
                'Prodotti'  => 'Prodotti',
                'Servizi'   => 'Servizi')
            ));

        $this->addElement('file', 'immagine', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images/aziende',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 204800),
        			array('Extension', false, array('jpg', 'gif', 'png', 'bmp'))
                    )));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Inserisci azienda',
            'class' => 'btn btn-primary'));
    }
}
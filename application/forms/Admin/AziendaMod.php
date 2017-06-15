<?php

class Application_Form_Admin_AziendaMod extends App_Form_Abstract
{    
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica azienda');
        $this->setAction('');
        
        // La seguente istruzione permette di usare i filtri custom
        $this->addElementPrefixPath('Filter', APPLICATION_PATH . '/../library/Filter', 'filter');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim')
            ));
        $this->getElement('nome')->addFilter(new Filter_Uc);
        
        $this->addElement('textarea', 'descrizione', array(
            'label' => 'Descrizione',
            'cols' => '50', 'rows' => '5',
            'filters' => array('StringTrim'),
            'required' => true,
            'decorators' => $this->elementDecorators,
            'placeholder' => 'Inserisci una descrizione dell\'azienda',
            'validators' => array(
                array('StringLength',true, array(1,1000)))
        ));
        
        $this->addElement('text', 'ragione_sociale', array(
            'label' => 'Ragione sociale',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim')));
        
        $this->addElement('text', 'localizzazione', array(
            'label' => 'Localizzazione',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        
        $this->addElement('select', 'tipologia', array(
            'label' => 'Tipologia',
            'required' => true,
            'decorators' => $this->elementDecorators,
            'multiOptions' => array(
                ''          => 'Seleziona',
                'Prodotti'  => 'Prodotti',
                'Servizi'   => 'Servizi'
                )));
        
        $this->addElement('hidden', 'idModifica', array(
            'required' => true
        ));

        $this->addElement('file', 'nuovaimmagine', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images/aziende',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 204800),
        			array('Extension', false, array('jpg', 'gif', 'png', 'bmp'))
                    )));
        
        $this->addElement('hidden', 'immagine');
        
        $this->addElement('submit', 'modifica', array(
            'label' => 'Applica modifiche',
            'class' => 'btn btn-primary'));
        
        $this->addElement('submit', 'cancella', array(
            'label' => 'Cancella azienda',
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
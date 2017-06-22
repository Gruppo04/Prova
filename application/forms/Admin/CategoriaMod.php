<?php

class Application_Form_Admin_CategoriaMod extends App_Form_Abstract
{
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica categoria');
        $this->setAction('');
        
        // La seguente istruzione permette di usare i filtri custom
        $this->addElementPrefixPath('Filter', APPLICATION_PATH . '/../library/Filter', 'filter');

        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true))
            )));
        $this->getElement('nome')->addFilter(new Filter_Uc);
        
        $this->addElement('textarea', 'descrizione', array(
            'label' => 'Descrizione',
            'cols' => '50', 'rows' => '5',
            'filters' => array('StringTrim'),
            'required' => true,
            'decorators' => $this->elementDecorators,
            'placeholder' => 'Inserisci una descrizione della categoria',
            'validators' => array(array('StringLength',true, array(1,1000)))
        ));
        
        $this->addElement('file', 'nuovaimmagine', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images/categorie',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 204800),
        			array('Extension', false, array('jpg', 'gif', 'png', 'bmp')))));
                
        $this->addElement('hidden', 'idModifica',array(
            'required' => true
        ));
        
        $this->addElement('hidden', 'immagine');
        
        $this->addElement('submit', 'modifica', array(
            'label' => 'Applica modifiche',
            'class' => 'btn btn-primary'));
        
        $this->addElement('submit', 'cancella', array(
            'label' => 'Cancella categoria',
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
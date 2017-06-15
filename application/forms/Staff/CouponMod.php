<?php

class Application_Form_Staff_CouponMod extends App_Form_Abstract
{
    protected $_staffModel;
    
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica coupon');
        $this->setAction('');
        $this->_staffModel = new Application_Model_Staff();
        
         // La seguente istruzione permette di usare i validator custom
        $this->addElementPrefixPath('Validator', APPLICATION_PATH . '/../library/Validator', 'validate');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'size' => '50',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim')
            ));
        
        $this->addElement('textarea', 'descrizione', array(
            'label' => 'Descrizione',
        	'cols' => '50', 'rows' => '5',
            'filters' => array('StringTrim'),
            'required' => true,
            'decorators' => $this->elementDecorators,
            'placeholder' => 'Inserisci una descrizione della promozione',
            'validators' => array(array('StringLength',true, array(1,1000)))
        ));
        
        $categorie = array();
        $cats = $this->_staffModel->getCategorie();
        foreach ($cats as $categoria) {
        	$categorie[$categoria->id] = $categoria->nome;
        }
        $this->addElement('select', 'idCategoria', array(
            'label' => 'Categoria',
            'required' => true,
            'decorators' => $this->elementDecorators,
            'multiOptions' => $categorie
            ));
        
        $aziende = array();
        $az = $this->_staffModel->getAziende();
        foreach ($az as $azienda) {
        	$aziende[$azienda->id] = $azienda->nome;
        }
        $this->addElement('select', 'idAzienda', array(
            'label' => 'Azienda emittente',
            'required' => true,
            'decorators' => $this->elementDecorators,
            'multiOptions' => $aziende
            ));
        
        $this->addElement('text', 'inizio_validita', array(
            'label' => 'Data inizio validità',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'placeholder' => 'aaaa-mm-gg',
            'filters' => array('StringTrim'),
            'validators' => array('Date')
            ));
        
        $this->addElement('text', 'scadenza', array(
            'label' => 'Data di scadenza',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'placeholder' => 'aaaa-mm-gg',
            'filters' => array('StringTrim'),
            'validators' => array('Date')
            ));
        $this->getElement('scadenza')->addValidator(new Validator_DataScad());
        
        $this->addElement('text', 'luogo_di_fruizione', array(
            'label' => 'Luogo di fruizione',
            'required' => 'true',
            'size' => '50',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim')
            ));
        
        $this->addElement('file', 'immagine', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images/coupon',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 204800),
        			array('Extension', false, array('jpg', 'gif', 'png', 'bmp')))));
        
        $this->addElement('hidden', 'idModifica',array(
            'required' => true
        ));
        
        $this->addElement('submit', 'modifica', array(
            'label' => 'Applica modifiche',
            'class' => 'btn btn-primary'));
        
        $this->addElement('submit', 'cancella', array(
            'label' => 'Cancella promozione',
            'class' => 'btn btn-primary'));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'zend_form')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }

}
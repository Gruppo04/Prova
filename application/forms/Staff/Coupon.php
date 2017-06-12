<?php

class Application_Form_Staff_Coupon extends Zend_Form
{
    protected $_staffModel;
    
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica coupon');
        $this->setAction('');
        $this->_staffModel = new Application_Model_Staff();
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'filters' => array('StringTrim')
            ));
        
        $this->addElement('textarea', 'descrizione', array(
            'label' => 'Descrizione',
        	'cols' => '50', 'rows' => '5',
            'filters' => array('StringTrim'),
            'required' => true,
            'autofocus'  => true,
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
            'multiOptions' => $aziende
            ));
        
        $this->addElement('text', 'inizio_validita', array(
            'label' => 'Data inizio validità',
            'required' => 'true',
            'placeholder' => 'aaaa-mm-gg',
            'filters' => array('StringTrim'),
            'validators' => array('Date')
            ));
        
        $this->addElement('text', 'scadenza', array(
            'label' => 'Data di scadenza',
            'required' => 'true',
            'placeholder' => 'aaaa-mm-gg',
            'filters' => array('StringTrim'),
            'validators' => array('Date')
            ));
        
        $this->addElement('text', 'luogo_di_fruizione', array(
            'label' => 'Luogo di fruizione',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true))
                )));
        
        $this->addElement('file', 'immagine', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images/coupon',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 204800),
        			array('Extension', false, array('jpg', 'gif', 'png', 'bmp')))));
        
        $this->addElement('submit', 'modifica', array(
            'label' => 'Aggiungi promozione',
            'class' => 'btn btn-primary'));
    }

}
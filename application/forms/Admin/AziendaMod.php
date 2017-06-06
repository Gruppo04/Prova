<?php

class Application_Form_Admin_AziendaMod extends Zend_Form
{
    //protected $_ucFilter;
    
    public function init() {
        
        //$this->_ucFilter = new Filter_Uc;
        $this->setMethod('post');
        $this->setName('registrazione azienda');
        $this->setAction('');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        
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
            'filters' => array('StringTrim')));
        
        $this->addElement('text', 'localizzazione', array(
            'label' => 'Localizzazione',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        
        $this->addElement('text', 'tipologia', array(
            'label' => 'Tipologia',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));

         $this->addElement('file', 'immagine', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 204800),
        			array('Extension', false, array('jpg', 'gif', 'png', 'bmp')))));
        
        $this->addElement('submit', 'add', array(
             'label' => 'Applica Modifiche'));
    }
    
//    public function populate($dati)
//    {
//      foreach($dati as $campo => $value)
//      {
//        $this->{$campo}->setValue($value);
//      }
//      return $this;
//    }

}
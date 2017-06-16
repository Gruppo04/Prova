<?php 

class Zend_View_Helper_GeneralImg extends Zend_View_Helper_HtmlElement 
{ 
	protected $_attrs; 
 
	public function generalImg($imgFile, $path , $attrs = false) 
	{ 
            if (empty($imgFile)) { 
                    $imgFile = 'default.jpg'; 
            } 
            if (null !== $attrs) { 
                    $_attrs = $this->_htmlAttribs($attrs); 
            } else { 
                    $_attrs = ''; 
            }
            /* La seguente istruzione contizionale non funziona in quanto da remoto non
             * è stato possibile modificare i permessi di rwx delle immagini sul server remoto
            if(!file_exists($this->view->baseUrl('images/'. $path . $imgFile))){
                $imgFile = 'default.jpg';
            }
            */
            $tag = '<img src="' . $this->view->baseUrl('images/'. $path . $imgFile) . '" ' . $_attrs . '>'; 
            return $tag;
	} 
}  

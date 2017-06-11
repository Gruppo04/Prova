<?php
class Zend_View_Helper_Slider extends Zend_View_Helper_Abstract
{
    private $percorso;
    private $oggi; 
    //private $diff;
    
    public function slider($validita, $imageFile)
    {
        if(is_int($validita)===true){
            $this->percorso=$imageFile;
        }else{
            $anno= substr($validita,0,4);
            $anno=(int)$anno;
            $mese= substr($validita,5,2);
            $mese=(int)$mese;
            $giorno= substr($validita,8,2);
            $giorno=(int)$giorno;
            $oggi= getdate();
            if($anno < ($this->oggi['year']) || $mese < ($this->oggi['mon']) || $giorno < ($this->oggi['mday']))
            {
                $this->percorso=$imageFile;
            }else{
                $this->percorso=false;
            }
        }
        return $this->percorso;
            
    }
}


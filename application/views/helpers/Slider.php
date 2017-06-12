<?php
class Zend_View_Helper_Slider extends Zend_View_Helper_Abstract
{
    private $oggi;
    
    public function slider($validita, $imageFile)
    {
        if(is_int($validita)===true){
            $percorso=$imageFile;
        }else{
            $anno= substr($validita,0,4);
            $anno=(int)$anno;
            $mese= substr($validita,5,2);
            $mese=(int)$mese;
            $giorno= substr($validita,8,2);
            $giorno=(int)$giorno;
            $this->oggi= getdate();
            if(($anno<$this->oggi['year']) || ($anno===$this->oggi['year'] && $mese<=$this->oggi['mon'] || $giorno<=$this->oggi['mday']))
            {
                $percorso=$imageFile;
            }else{
                $percorso=false;
            }
        }
        return $percorso;
    }
}


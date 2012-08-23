<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TMDbEvent
 *
 * @author andrei
 */
class TMDbEvent extends CModelEvent
{

    protected $_data;

    public function getData()
    {
        return $this->_data;
    }

    public function setData($data)
    {
        $this->_data = $data;
        
        return $this;
    }

}

?>

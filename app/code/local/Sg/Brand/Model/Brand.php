<?php

class SG_Brand_Model_Brand extends Mage_Core_Model_Abstract
{
    function __construct()
    {
        $this->_init('brand/brand');
    }

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }
}
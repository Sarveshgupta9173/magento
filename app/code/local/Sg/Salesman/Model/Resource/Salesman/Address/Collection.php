<?php

class SG_Salesman_Model_Resource_Salesman_Address_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        //address collection
        $this->_init('salesman/salesman_address');
    }
}
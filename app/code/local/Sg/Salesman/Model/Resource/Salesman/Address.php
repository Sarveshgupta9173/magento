<?php
class SG_Salesman_Model_Resource_Salesman_Address extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        //address resource
        $this->_init('salesman/salesman_address' ,'address_id');
    }
}
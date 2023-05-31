<?php

class Ccc_User_Model_User extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('user/user');
    }

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }
}

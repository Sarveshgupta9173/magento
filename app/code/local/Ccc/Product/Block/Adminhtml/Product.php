<?php

class Ccc_Product_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        
        $this->_blockGroup = 'product';
        $this->_controller = 'adminhtml_product';
        $this->_headerText = Mage::helper('product')->__('Manage products');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('product')->__('Add New product'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('product/adminhtml_vendor/' . $action);
    }

}
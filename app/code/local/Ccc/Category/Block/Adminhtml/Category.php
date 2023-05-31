<?php

class Ccc_Category_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        
        $this->_blockGroup = 'category';
        $this->_controller = 'adminhtml_category';
        $this->_headerText = Mage::helper('category')->__('Manage Categories');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('category')->__('Add New Categories'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('category/adminhtml_category/' . $action);
    }

}
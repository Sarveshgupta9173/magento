<?php

class SG_Vendor_Block_Adminhtml_Vendor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('vendor')->__('Vendor Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('vendor')->__('Vendor'),
            'title' => Mage::helper('vendor')->__('Vendor Information'),
            'content' => $this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tab_form')->toHtml(),
        ));

        $this->addTab('form_section_address', array(
            'label' => Mage::helper('vendor')->__('Addresses'),
            'content' => $this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tab_addresses')->toHtml(),
        ));


        return parent::_beforeToHtml();
    }
}





    
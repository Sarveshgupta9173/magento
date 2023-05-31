<?php

class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('salesman')->__('salesman Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('salesman')->__('salesman'),
            'title' => Mage::helper('salesman')->__('salesman Information'),
            'content' => $this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tab_form')->toHtml(),
        ));

        


        return parent::_beforeToHtml();
    }
}
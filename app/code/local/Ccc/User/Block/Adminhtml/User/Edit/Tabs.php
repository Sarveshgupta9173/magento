<?php

class Ccc_User_Block_Adminhtml_User_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('user')->__('user Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('user')->__('user'),
            'title' => Mage::helper('user')->__('user Information'),
            'content' => $this->getLayout()->createBlock('user/adminhtml_user_edit_tab_form')->toHtml(),
        ));

        


        return parent::_beforeToHtml();
    }
}
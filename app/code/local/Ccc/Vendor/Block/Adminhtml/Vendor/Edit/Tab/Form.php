<?php

class Ccc_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('vendor_form',array('legend'=>Mage::helper('vendor')->__('Vendor Information')));

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('vendor')->__('First Name'),
            'required' => true,
            'name' => 'vendor[first_name]',
        ));

        $fieldset->addField('last_name','text', array(
            'label' => Mage::helper('vendor')->__('Last Name'),
            'required' => true,
            'name' => 'vendor[last_name]'
        ));

        $fieldset->addField('mobile','text', array(
            'label' => Mage::helper('vendor')->__('Mobile'),
            'required' => true,
            'name' => 'vendor[mobile]'
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('vendor')->__('Email'),
            'required' => true,
            'name' => 'vendor[email]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } elseif ( Mage::registry('vendor_edit') ) {
            $form->setValues(Mage::registry('vendor_edit')->getData());
        }
        return parent::_prepareForm();


    }

}
<?php

class SG_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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

        $fieldset->addField('gender', 'radios', array(
            'label' => Mage::helper('vendor')->__('Gender'),
            'name' => 'vendor[gender]',
            'values' => array(
                array('value' => 1, 'label' => 'Male'),
                array('value' => 2, 'label' => 'Female'),
                array('value' => 3, 'label' => 'Other')
            ),
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('vendor')->__('Status'),
            'required' => true,
            'name' => 'vendor[status]',
            'options' => array(
                1 => Mage::helper('vendor')->__('Active'),
                2 => Mage::helper('vendor')->__('Inactive'),
            ),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } 
        elseif ( Mage::registry('vendor_edit') ) {
            $form->setValues(Mage::registry('vendor_edit')->getData());
        }
        return parent::_prepareForm();


    }

}





    
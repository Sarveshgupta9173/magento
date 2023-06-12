<?php

class SG_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('vendor_form',array('legend'=>Mage::helper('vendor')->__('Vendor Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('vendor')->__(' Name'),
            'required' => true,
            'name' => 'vendor[name]',
        ));

        $fieldset->addField('email','text', array(
            'label' => Mage::helper('vendor')->__('Email '),
            'required' => true,
            'name' => 'vendor[email]'
        ));

         $fieldset->addField('password','text', array(
            'label' => Mage::helper('vendor')->__('Password'),
            'required' => true,
            'name' => 'vendor[password]'
        ));

        $fieldset->addField('mobile','text', array(
            'label' => Mage::helper('vendor')->__('Mobile'),
            'required' => true,
            'name' => 'vendor[mobile]'
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





    
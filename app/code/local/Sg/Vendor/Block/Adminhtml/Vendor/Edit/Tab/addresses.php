<?php

class SG_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Addresses extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        //setting the field form addresses
        $fieldset = $form->addFieldset('vendor_form',array('legend'=>Mage::helper('vendor')->__('Vendor Addresses')));

        $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('vendor')->__('Address'),
            'required' => false,
            'name' => 'address[address]',
        ));

        $fieldset->addField('city','text', array(
            'label' => Mage::helper('vendor')->__('City'),
            'required' => false,
            'name' => 'address[city]'
        ));

        $fieldset->addField('state', 'text', array(
            'label' => Mage::helper('vendor')->__('State'),
            'required' => false,
            'name' => 'address[state]',
        ));

        $fieldset->addField('country','text', array(
            'label' => Mage::helper('vendor')->__('Country'),
            'required' => false,
            'name' => 'address[country]'
        ));

        $fieldset->addField('zipcode','text', array(
            'label' => Mage::helper('vendor')->__('Zipcode'),
            'required' => false,
            'name' => 'address[zipcode]'
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } 
        elseif ( Mage::registry('address_edit') ) {
            $form->setValues(Mage::registry('address_edit')->getData());
        }
        return parent::_prepareForm();

    }

}





    
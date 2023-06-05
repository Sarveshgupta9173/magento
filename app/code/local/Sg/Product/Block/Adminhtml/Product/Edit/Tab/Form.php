<?php

class SG_Product_Block_Adminhtml_Product_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('product_form',array('legend'=>Mage::helper('product')->__('Product Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('product')->__('Name'),
            'required' => true,
            'name' => 'product[name]',
        ));

        $fieldset->addField('sku','text', array(
            'label' => Mage::helper('product')->__('SKU'),
            'required' => true,
            'name' => 'product[sku]'
        ));

        $fieldset->addField('cost','text', array(
            'label' => Mage::helper('product')->__('COST'),
            'required' => true,
            'name' => 'product[cost]'
        ));

        $fieldset->addField('price', 'text', array(
            'label' => Mage::helper('product')->__('Price'),
            'required' => true,
            'name' => 'product[price]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } elseif ( Mage::registry('product_edit') ) {
            $form->setValues(Mage::registry('product_edit')->getData());
        }
        return parent::_prepareForm();


    }

}
<?php

class Ccc_Product_Block_Adminhtml_Product_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('product_form',array('legend'=>Mage::helper('product')->__('product Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('product')->__('Product Name'),
            'required' => true,
            'name' => 'product[name]',
        ));

        $fieldset->addField('sku','text', array(
            'label' => Mage::helper('product')->__('Sku'),
            'required' => true,
            'name' => 'product[sku]'
        ));

        $fieldset->addField('cost','text', array(
            'label' => Mage::helper('product')->__('Cost'),
            'required' => true,
            'name' => 'product[cost]'
        ));

        $fieldset->addField('price', 'text', array(
            'label' => Mage::helper('product')->__('Price'),
            'required' => true,
            'name' => 'product[price]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getProductData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getProductData());
            Mage::getSingleton('adminhtml/session')->setProductData(null);
        } elseif ( Mage::registry('product_edit') ) {
            $form->setValues(Mage::registry('product_edit')->getData());
        }
        return parent::_prepareForm();


    }

}
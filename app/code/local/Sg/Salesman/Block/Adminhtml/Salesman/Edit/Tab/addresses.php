<?php

class SG_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Addresses extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        //setting the field form addresses
        $fieldset = $form->addFieldset('salesman_form',array('legend'=>Mage::helper('salesman')->__('salesman Addresses')));

        $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('salesman')->__('Address'),
            'required' => false,
            'name' => 'address[address]',
        ));

        $fieldset->addField('city','text', array(
            'label' => Mage::helper('salesman')->__('City'),
            'required' => false,
            'name' => 'address[city]'
        ));

        $fieldset->addField('state', 'text', array(
            'label' => Mage::helper('salesman')->__('State'),
            'required' => false,
            'name' => 'address[state]',
        ));

        $fieldset->addField('country','text', array(
            'label' => Mage::helper('salesman')->__('Country'),
            'required' => false,
            'name' => 'address[country]'
        ));

        $fieldset->addField('zipcode','text', array(
            'label' => Mage::helper('salesman')->__('Zipcode'),
            'required' => false,
            'name' => 'address[zipcode]'
        ));

        if ( Mage::getSingleton('adminhtml/session')->getSalesmanData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSalesmanData());
            Mage::getSingleton('adminhtml/session')->getSalesmanData(null);
        } 
        elseif ( Mage::registry('address_edit') ) {
            $form->setValues(Mage::registry('address_edit')->getData());
        }
        return parent::_prepareForm();

    }

}





    
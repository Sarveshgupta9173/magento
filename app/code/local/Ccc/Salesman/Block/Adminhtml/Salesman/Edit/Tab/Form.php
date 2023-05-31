<?php

class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('salesman_form',array('legend'=>Mage::helper('salesman')->__('salesman Information')));

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('salesman')->__('First Name'),
            'required' => true,
            'name' => 'salesman[first_name]',
        ));

        $fieldset->addField('last_name','text', array(
            'label' => Mage::helper('salesman')->__('Last Name'),
            'required' => true,
            'name' => 'salesman[last_name]'
        ));

        $fieldset->addField('email','text', array(
            'label' => Mage::helper('salesman')->__('Email'),
            'required' => true,
            'name' => 'salesman[email]'
        ));

        $fieldset->addField('gender','text', array(
            'label' => Mage::helper('salesman')->__('Gender'),
            'required' => true,
            'name' => 'salesman[gender]'
        ));

        $fieldset->addField('mobile','text', array(
            'label' => Mage::helper('salesman')->__('Mobile'),
            'required' => true,
            'name' => 'salesman[mobile]'
        ));

        $fieldset->addField('status','select', array(
            'label' => Mage::helper('salesman')->__('Status'),
            'required' => true,
            'name' => 'salesman[status]',
            'options'=> [1 =>'Active', 2 =>'Inactive']
        ));

      

        if ( Mage::getSingleton('adminhtml/session')->getSalesmanData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSalesmanData());
            Mage::getSingleton('adminhtml/session')->setSalesmanData(null);
        } elseif ( Mage::registry('salesman_edit') ) {
            $form->setValues(Mage::registry('salesman_edit')->getData());
        }
        return parent::_prepareForm();


    }

}
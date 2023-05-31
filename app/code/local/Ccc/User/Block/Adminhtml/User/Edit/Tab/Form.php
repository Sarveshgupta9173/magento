<?php

class Ccc_User_Block_Adminhtml_User_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('user_form',array('legend'=>Mage::helper('user')->__('User Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('user')->__('Name'),
            'required' => true,
            'name' => 'user[name]',
        ));

        $fieldset->addField('email','text', array(
            'label' => Mage::helper('user')->__('Email'),
            'required' => true,
            'name' => 'user[email]'
        ));

        $fieldset->addField('password','text', array(
            'label' => Mage::helper('user')->__('Password'),
            'required' => true,
            'name' => 'user[password]'
        ));

        if ( Mage::getSingleton('adminhtml/session')->getUserData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getUserData());
            Mage::getSingleton('adminhtml/session')->getUserData(null);
        } elseif ( Mage::registry('user_edit') ) {
            $form->setValues(Mage::registry('user_edit')->getData());
        }
        return parent::_prepareForm();


    }

}
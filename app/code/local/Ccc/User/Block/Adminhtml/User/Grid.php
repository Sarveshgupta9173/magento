<?php

class Ccc_User_Block_Adminhtml_User_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('userAdminhtmlUserGrid');
        $this->setDefaultSort('user_id');
        $this->setDefaultDir('ASC');
    }
    
   protected function _prepareCollection()
    {
        // echo "<pre>";
        $collection = Mage::getModel('user/user')->getCollection();
        // print_r($collection->getData()); die();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => Mage::helper('user')->__('Name'),
            'align'     => 'left',
            'index'     => 'name'
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('user')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

        $this->addColumn('password', array(
            'header'    => Mage::helper('product')->__('Password'),
            'align'     => 'left',
            'index'     => 'password'
        ));

      

        
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('user_id');
        $this->getMassactionBlock()->setFormFieldName('user');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('user')->__('Multiple Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('user')->__('Are you sure?')
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('user_id' => $row->getId()));
    }
   
}
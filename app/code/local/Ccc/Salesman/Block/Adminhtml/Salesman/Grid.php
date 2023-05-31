<?php

class Ccc_Salesman_Block_Adminhtml_Salesman_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('salesmanAdminhtmlSalesmanGrid');
        $this->setDefaultSort('salesman_id');
        $this->setDefaultDir('ASC');
    }
    
   protected function _prepareCollection()
    {
        // echo "<pre>";
        $collection = Mage::getModel('salesman/salesman')->getCollection();
        // print_r($collection->getData()); die();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('first_name', array(
            'header'    => Mage::helper('salesman')->__('First Name'),
            'align'     => 'left',
            'index'     => 'first_name'
        ));

        $this->addColumn('lastname', array(
            'header'    => Mage::helper('salesman')->__('Last Name'),
            'align'     => 'left',
            'index'     => 'last_name'
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('salesman')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

        $this->addColumn('gender', array(
            'header'    => Mage::helper('salesman')->__('Gender'),
            'align'     => 'left',
            'index'     => 'gender'
        ));

         $this->addColumn('mobile', array(
            'header'    => Mage::helper('salesman')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('salesman')->__('Status'),
            'align'     => 'left',
            'index'     => 'status'
        ));


        
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('salesman_id');
        $this->getMassactionBlock()->setFormFieldName('salesman');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('salesman')->__('Multiple Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('salesman')->__('Are you sure?')
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('salesman_id' => $row->getId()));
    }
   
}
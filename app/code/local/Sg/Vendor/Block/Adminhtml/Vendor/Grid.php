<?php

class SG_Vendor_Block_Adminhtml_Vendor_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('vendorAdminhtmlVendorGrid');
        $this->setDefaultSort('vendor_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('vendor/vendor')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => Mage::helper('vendor')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('vendor')->__('Email '),
            'align'     => 'left',
            'index'     => 'email'
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('vendor')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('vendor')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
        ));


        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('vendor_id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('vendor_id');
        $this->getMassactionBlock()->setFormFieldName('vendor_id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('vendor')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('vendor')->__('Are you sure?')
        ));

        $statuses = [1=>'Active',2=>'Inactive'];
        $this->getMassactionBlock()->addItem('status', array(
             'label'    => Mage::helper('vendor')->__('Status'),
             'url'      => $this->getUrl('*/*/massStatus'),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('catalog')->__('Update Status'),
                         'values' => $statuses
                     )
             )
        ));


        return $this;
    }
   
}
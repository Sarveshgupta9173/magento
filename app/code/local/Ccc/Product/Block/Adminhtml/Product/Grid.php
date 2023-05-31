<?php

class Ccc_Product_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productAdminhtmlVendorGrid');
        $this->setDefaultSort('product_id');
        $this->setDefaultDir('ASC');
    }
    
   protected function _prepareCollection()
    {
        // echo "<pre>";
        $collection = Mage::getModel('product/product')->getCollection();
        // print_r($collection->getData()); die();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => Mage::helper('product')->__('Product Name'),
            'align'     => 'left',
            'index'     => 'name'
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('product')->__('Sku'),
            'align'     => 'left',
            'index'     => 'sku'
        ));

        $this->addColumn('cost', array(
            'header'    => Mage::helper('product')->__('Cost'),
            'align'     => 'left',
            // 'sortable'     => true,
            'index'     => 'cost'
        ));

      

        $this->addColumn('price', array(
            'header'    => Mage::helper('product')->__('Price'),
            'align'     => 'left',
            'index'     => 'price'
        ));

        
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('product_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('product')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('product')->__('Are you sure?')
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('product_id' => $row->getId()));
    }
   
}
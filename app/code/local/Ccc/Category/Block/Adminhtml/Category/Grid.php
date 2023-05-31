<?php

class Ccc_Category_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryAdminhtmlCategoryGrid');
        $this->setDefaultSort('category_id');
        $this->setDefaultDir('ASC');
    }
    
   protected function _prepareCollection()
    {
        // echo "<pre>";
        $collection = Mage::getModel('category/category')->getCollection();
        // print_r($collection->getData()); die();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('category_id', array(
            'header'    => Mage::helper('category')->__('Category Id'),
            'align'     => 'left',
            'index'     => 'category_id'
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('category')->__('Category Name'),
            'align'     => 'left',
            'index'     => 'name'
        ));

        $this->addColumn('description', array(
            'header'    => Mage::helper('category')->__('Description'),
            'align'     => 'left',
            'index'     => 'description'
        ));

         $this->addColumn('status', array(
            'header'    => Mage::helper('category')->__('Status'),
            'align'     => 'left',
            'index'     => 'status'
        ));

        
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('category_id');
        $this->getMassactionBlock()->setFormFieldName('category');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('category')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('category')->__('Are you sure?')
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}
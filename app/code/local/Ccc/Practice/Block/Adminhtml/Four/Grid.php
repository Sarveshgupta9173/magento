<?php
class Ccc_Practice_Block_Adminhtml_Four_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('PracticeAdminhtmlPracticeGrid');
        $this->setDefaultSort('category_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
       $products = Mage::getModel('catalog/product')->getCollection();
        $products->addAttributeToSelect(array('name','sku','image','small_image','thumbnail'));
        $this->setCollection($products);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('practice')->__('product_id'),
            'align'     => 'left',
            'index'     => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('practice')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('base_image', array(
            'header'    => Mage::helper('practice')->__('base image'),
            'align'     => 'left',
            'index'     => 'image',
            'renderer'  =>'ccc_practice_block_adminhtml_four_renderer_image'
        ));

        $this->addColumn('small_image', array(
            'header'    => Mage::helper('practice')->__('small image'),
            'align'     => 'left',
            'index'     => 'small_image',
            'renderer'  =>'Ccc_Practice_Block_Adminhtml_Four_Renderer_Small'
        ));

        $this->addColumn('thumb_image', array(
            'header'    => Mage::helper('practice')->__('thumb image'),
            'align'     => 'left',
            'index'     => 'small_image',
            'renderer'  =>'Ccc_Practice_Block_Adminhtml_Four_Renderer_Thumb'
        ));


        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}
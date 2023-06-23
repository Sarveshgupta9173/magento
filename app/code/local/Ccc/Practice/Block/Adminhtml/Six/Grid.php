<?php
class Ccc_Practice_Block_Adminhtml_Six_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('PracticeAdminhtmlPracticeGrid');
        $this->setDefaultSort('order_count');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customer/customer')->getCollection()
        ->addAttributeToSelect('*');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('customer_id', array(
            'header'    => Mage::helper('practice')->__('customer_id'),
            'align'     => 'left',
            'index'     => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('practice')->__('name'),
            'align'     => 'left',
            'index'     => 'name',
            'renderer'  =>'ccc_practice_block_adminhtml_six_renderer_name'
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('practice')->__('email'),
            'align'     => 'left',
            'index'     => 'email',
        ));

        $this->addColumn('order_count', array(
            'header'    => Mage::helper('practice')->__('order count'),
            'align'     => 'left',
            'index'     => 'order_count',
            'renderer'  => 'ccc_practice_block_adminhtml_six_renderer_ordercount'
        ));


        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}

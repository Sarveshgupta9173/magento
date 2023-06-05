<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class SG_Product_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();

    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('product/product')
            ->_addBreadcrumb(Mage::helper('product')->__('product Manager'), Mage::helper('product')->__('product Manager'))
            ->_addBreadcrumb(Mage::helper('product')->__('Manage Product'), Mage::helper('product')->__('Manage product'))
        ;
        return $this;
    }

    public function editAction()
    {
        $this->_title($this->__('product'))
             ->_title($this->__('products'))
             ->_title($this->__('Edit products'));

        // print_r($this->_addContent($this->getLayout()->createBlock('Ccc_vendor_Block_Adminhtml_vendor_Edit')));
        $id = $this->getRequest()->getParam('product_id');
        $model = Mage::getModel('product/product');
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('product')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        // echo "<pre>";print_r($model->load($id));die;
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New product'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('product_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('product')->__('Edit product')
                    : Mage::helper('product')->__('New product'),
                $id ? Mage::helper('product')->__('Edit product')
                    : Mage::helper('product')->__('New product'));

        $this->_addContent($this->getLayout()->createBlock(' product/adminhtml_product_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('product/adminhtml_product_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }


    public function saveAction()
    {
        try {
           
            $model = Mage::getModel('product/product');
            $data = $this->getRequest()->getPost('product');
            $productId = $this->getRequest()->getParam('id');
            if (!$productId)
            {
                $productId = $this->getRequest()->getParam('product_id');
            }

            $model->setData($data)->setId($productId);
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('product')->__('product was successfully saved'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
             
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('product_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('product')->__('Unable to find product to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('product_id') > 0 ) {
            try {
                $model = Mage::getModel('product/product');
                 
                $model->setId($this->getRequest()->getParam('product_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('product was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('product_id')));
            }
        }
        $this->_redirect('*/*/');
    }

     public function massDeleteAction()
    {
        $vendorIds = $this->getRequest()->getParam('product');
        // print_r($productIds); die();
        if(!is_array($productIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select product(s).'));
        } else {
            try {
                $product = Mage::getModel('product/product');
                foreach ($productIds as $productId) {
                    $product->reset()
                        ->load($productId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($productIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}
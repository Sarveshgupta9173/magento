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

class Ccc_Vendor_Adminhtml_VendorController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        // $this->loadLayout();
        // $block = $this->getLayout()->createBlock('vendor/test');
        // $this->getLayout()->createBlock('vendor/test','test')->getBlock('content');
        // // print_r(get_class_methods($r));
    
        // // print_r(get_class($block));

        // $this->renderLayout();
        // // echo $block->toHtml();
        // echo "Controller Working...";
        $this->_title($this->__('Vendor'))->_title($this->__('Manage Vendors'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_vendor'));
        $this->renderLayout();



       // $vendor = Mage::getModel('vendor/vendor');
       // $vendor->name = "dhruv";
       // $vendor->email = "dhruv@gmail.com";
       // $vendor->mobile = "111";

       // print_r($vendor->save());
       // die();
        



        // $model = Mage::getModel('vendor/test');

        // print_r($model);

        // $helper = Mage::helper('vendor/test');
        // print_r($helper);

        // $helperData = Mage::helper('vendor/data');
        // print_r($helperData);

         

         // die;
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('vendor/vendor')
            ->_addBreadcrumb(Mage::helper('vendor')->__('vendor Manager'), Mage::helper('vendor')->__('vendor Manager'))
            ->_addBreadcrumb(Mage::helper('vendor')->__('Manage vendor'), Mage::helper('vendor')->__('Manage vendor'))
        ;
        return $this;
    }

    public function editAction()
    {
        $this->_title($this->__('vendor'))
             ->_title($this->__('vendors'))
             ->_title($this->__('Edit vendors'));

        // print_r($this->_addContent($this->getLayout()->createBlock('Ccc_vendor_Block_Adminhtml_vendor_Edit')));
        $id = $this->getRequest()->getParam('vendor_id');
        $model = Mage::getModel('vendor/vendor');
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vendor')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        // echo "<pre>";print_r($model->load($id));die;
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Vendor'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('vendor_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('vendor')->__('Edit vendor')
                    : Mage::helper('vendor')->__('New vendor'),
                $id ? Mage::helper('vendor')->__('Edit vendor')
                    : Mage::helper('vendor')->__('New vendor'));

        $this->_addContent($this->getLayout()->createBlock(' vendor/adminhtml_vendor_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('vendor/adminhtml_vendor_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }


    public function saveAction()
    {
        try {
            // $model = Mage::getModel('vendor/vendor');
            // $data = $this->getRequest()->getPost();
            // // print_r($data); die();
            // if (!$this->getRequest()->getParam('id'))
            // {
            //     $model->setData($data)->setId($this->getRequest()->getParam('vendor_id'));
            // }
            // // echo "<pre>";
            // // print_r($model->setData($data));

            // $model->setData($data)->setId($this->getRequest()->getParam('id'));
            // // die();
            // // if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            // // {
            // //     $model->setCreatedTime(now())->setUpdateTime(now());
            // // } 
            // // else {
            // //     $model->setUpdateTime(now());
            // // }
            // $model->save();

            $model = Mage::getModel('vendor/vendor');
            $data = $this->getRequest()->getPost('vendor');
            $vendorId = $this->getRequest()->getParam('id');
            if (!$vendorId)
            {
                $vendorId = $this->getRequest()->getParam('vendor_id');
            }

            $model->setData($data)->setId($vendorId);
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendor')->__('vendor was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('vendor_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Unable to find vendor to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('vendor_id') > 0 ) {
            try {
                $model = Mage::getModel('vendor/vendor');
                 
                $model->setId($this->getRequest()->getParam('vendor_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('vendor was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('vendor_id')));
            }
        }
        $this->_redirect('*/*/');
    }

     public function massDeleteAction()
    {
        $vendorIds = $this->getRequest()->getParam('vendor');
        // print_r($vendorIds); die();
        if(!is_array($vendorIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select vendor(s).'));
        } else {
            try {
                $vendor = Mage::getModel('vendor/vendor');
                foreach ($vendorIds as $vendorId) {
                    $vendor->reset()
                        ->load($vendorId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($vendorIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}

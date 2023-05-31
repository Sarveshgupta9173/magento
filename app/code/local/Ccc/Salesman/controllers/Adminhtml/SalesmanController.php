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

class Ccc_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        $this->_title($this->__('Salesman'))->_title($this->__('Manage Salesmans'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_Salesman'));
        $this->renderLayout();

    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('salesman/salesman')
            ->_addBreadcrumb(Mage::helper('salesman')->__('Salesman Manager'), Mage::helper('salesman')->__('Salesman Manager'))
            ->_addBreadcrumb(Mage::helper('salesman')->__('Manage Salesman'), Mage::helper('salesman')->__('Manage Salesman'))
        ;
        return $this;
    }

    public function editAction()
    {
        $this->_title($this->__('salesman'))
             ->_title($this->__('salesman'))
             ->_title($this->__('Edit Salesmans'));

        // print_r($this->_addContent($this->getLayout()->createBlock('Ccc_vendor_Block_Adminhtml_vendor_Edit')));
        $id = $this->getRequest()->getParam('salesman_id');
        $model = Mage::getModel('salesman/salesman');
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('salesman')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        // echo "<pre>";print_r($model->load($id));die;
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Salesman'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('salesman_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('salesman')->__('Edit Salesman')
                    : Mage::helper('salesman')->__('New Salesman'),
                $id ? Mage::helper('salesman')->__('Edit Salesman')
                    : Mage::helper('salesman')->__('New Salesman'));

        $this->_addContent($this->getLayout()->createBlock(' salesman/adminhtml_salesman_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('salesman/adminhtml_salesman_edit_tabs'));

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

            $model = Mage::getModel('salesman/salesman');
            $data = $this->getRequest()->getPost('salesman');
            $SalesmanId = $this->getRequest()->getParam('id');
            if (!$SalesmanId)
            {
                $SalesmanId = $this->getRequest()->getParam('salesman_id');
            }

            $model->setData($data)->setId($SalesmanId);
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('salesman')->__('Salesman was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('salesman_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('Unable to find Salesman to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('salesman_id') > 0 ) {
            try {
                $model = Mage::getModel('salesman/salesman');
                 
                $model->setId($this->getRequest()->getParam('salesman_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Salesman was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('salesman_id')));
            }
        }
        $this->_redirect('*/*/');
    }

     public function massDeleteAction()
    {
        $salesmanIds = $this->getRequest()->getParam('salesman');
        // print_r($salesmanIds); die();
        if(!is_array($salesmanIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Salesman(s).'));
        } else {
            try {
                $salesman = Mage::getModel('salesman/salesman');
                foreach ($salesmanIds as $salesmanId) {
                    $salesman->reset()
                        ->load($salesmanId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($salesmanIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}

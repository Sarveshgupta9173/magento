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


class SG_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Salesman'))
             ->_title($this->__('Manage Salesmans'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_salesman'));
        $this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('salesman/salesman')
            ->_addBreadcrumb(Mage::helper('salesman')->__('salesman Manager'), Mage::helper('salesman')->__('salesman Manager'))
            ->_addBreadcrumb(Mage::helper('salesman')->__('Manage salesman'), Mage::helper('salesman')->__('Manage salesman'))
        ;
        return $this;
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('salesman'))
             ->_title($this->__('salesmans'))
             ->_title($this->__('Edit salesmans'));

        $id = $this->getRequest()->getParam('salesman_id');
        $model = Mage::getModel('salesman/salesman');
        //getting address model also
        $addressModel = Mage::getModel('salesman/salesman_address');

        if ($id) {
            $model->load($id);
            $addressModel->load($id,'salesman_id');
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('salesman')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New salesman'));
        $this->_title($addressModel->getId() ? $addressModel->getTitle() : $this->__('New salesman Address'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('salesman_edit',$model);
        Mage::register('address_edit',$addressModel);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('salesman')->__('Edit salesman')
                    : Mage::helper('salesman')->__('New salesman'),
                $id ? Mage::helper('salesman')->__('Edit salesman')
                    : Mage::helper('salesman')->__('New salesman'));

        $this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_salesman_edit'))
                ->_addLeft($this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tabs'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('salesman/salesman');
            $addressModel = Mage::getModel('salesman/salesman_address');
            $addressData = $this->getRequest()->getPost('address');
            $data = $this->getRequest()->getPost('salesman');
            $salesmanId = $this->getRequest()->getParam('id');
            if (!$salesmanId)
            {
                $salesmanId = $this->getRequest()->getParam('salesman_id');
            }

            $model->setData($data)->setId($salesmanId);
           
            $model->save();
            if ($model->save()) {
                if ($salesmanId) {
                    $addressModel->load($salesmanId,'salesman_id');
                }
                //address model setting the data
                $addressModel->setData(array_merge($addressModel->getData(),$addressData));
                $addressModel->salesman_id = $model->salesman_id;
                $addressModel->save();
            }
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

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('Unable to find salesman to save'));
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
}
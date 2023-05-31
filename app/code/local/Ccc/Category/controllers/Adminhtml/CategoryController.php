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

class Ccc_Category_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        // $this->loadLayout();
        // $block = $this->getLayout()->createBlock('category/test');
        // $this->getLayout()->createBlock('category/test','test')->getBlock('content');
        // // print_r(get_class_methods($r));
    
        // // print_r(get_class($block));

        // $this->renderLayout();
        // // echo $block->toHtml();
        // echo "Controller Working...";
        $this->_title($this->__('Category'))->_title($this->__('Manage Categories'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('category/adminhtml_category'));
        $this->renderLayout();

    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('category/category')
            ->_addBreadcrumb(Mage::helper('category')->__('category Manager'), Mage::helper('category')->__('category Manager'))
            ->_addBreadcrumb(Mage::helper('category')->__('Manage category'), Mage::helper('category')->__('Manage category'))
        ;
        return $this;
    }

    public function editAction()
    {
        $this->_title($this->__('category'))
             ->_title($this->__('categories'))
             ->_title($this->__('Edit categories'));

        // print_r($this->_addContent($this->getLayout()->createBlock('Ccc_category_Block_Adminhtml_category_Edit')));
        $id = $this->getRequest()->getParam('category_id');
        $model = Mage::getModel('category/category');
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('category')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        // echo "<pre>";print_r($model->load($id));die;
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Category'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('category_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('category')->__('Edit category')
                    : Mage::helper('category')->__('New category'),
                $id ? Mage::helper('category')->__('Edit category')
                    : Mage::helper('category')->__('New category'));

        $this->_addContent($this->getLayout()->createBlock(' category/adminhtml_category_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('category/adminhtml_category_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }


    public function saveAction()
    {
        try {

            $model = Mage::getModel('category/category');
            $data = $this->getRequest()->getPost('category');
            $categoryId = $this->getRequest()->getParam('id');
            if (!$categoryId)
            {
                $categoryId = $this->getRequest()->getParam('category_id');
            }

            $model->setData($data)->setId($categoryId);
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('category')->__('category was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('category_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('category')->__('Unable to find category to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('category_id') > 0 ) {
            try {
                $model = Mage::getModel('category/category');
                 
                $model->setId($this->getRequest()->getParam('category_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('category was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('category_id')));
            }
        }
        $this->_redirect('*/*/');
    }

     public function massDeleteAction()
    {
        $categoryIds = $this->getRequest()->getParam('category');
        if(!is_array($categoryIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select category(s).'));
        } else {
            try {
                $category = Mage::getModel('category/category');
                foreach ($categoryIds as $categoryId) {
                    $category->reset()
                        ->load($categoryId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($categoryIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}

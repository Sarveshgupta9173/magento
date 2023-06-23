<?php
class Ccc_Practice_Adminhtml_CsvController extends Mage_Adminhtml_Controller_Action
{

     public function twoAction()
    {
        $csvMergeObj = Mage::helper('practice/csvmerge');
        
        $csvMergeObj->setCategoryFile('C:\Users\Admin\Downloads\CATEGORY.csv');
        $csvMergeObj->setOptionFile('C:\Users\Admin\Downloads\ATTRIBUTE-OPTIONS.csv');
        $csvMergeObj->setFinalFile('C:\Users\Admin\Downloads\category-attribute-option.csv');

        $file = $csvMergeObj->run();
        
        
        $this->_prepareDownloadResponse('category-attribute-option.csv', file_get_contents($file));
    }
}

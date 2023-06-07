<?php
class SG_Practice_OneController extends Mage_Core_Controller_Front_Action
{
    
    protected function indexAction()
    {
        echo "<pre>";
        $template = new Mage_Core_Block_Template();
        $r=$template->getTemplate();
        $r=$template->getTemplateFile();
        $r = $template->getArea();
        print_r($r); 
        print_r($template->getDirectOutput());
        // print_r($template->getBaseUrl());
        // print_r($template->getJsUrl());
        // print_r($template->_getAllowSymlinks());

        
        $textList = new Mage_Core_Block_Text_list();
        // print_r($textList->_toHtml());

        // $abstract = new Mage_Core_Block_Abstract();
        // print_r($abstract);

        $resource = new Mage_Core_Model_Resource();
        // print_r($resource->getConnection('name'));
        // print_r($resource->getConnections());
        // print_r($resource->getAutoUpdate());

        $url = new Mage_Core_Model_Url();
        // print_r($url);
        print_r($url->getActionPath());





    }
}
   
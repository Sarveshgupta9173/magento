<?php

class SG_Brand_Model_Observer
{
    public function generateRewriteUrl($observer)
    {
        $brand = $observer->getBrand();
        $urlKey = $brand->getUrlKey();
        $rewrite = Mage::getModel('core/url_rewrite')->load('brand/'.$brand->getId(),'id_path');
        $rewrite->setStoreId($brand->getStoreId())
                ->setIdPath('brand/'.$brand->getId())
                ->setRequestPath($urlKey)
                ->setTargetPath('brand/frontend/view/brand_id/'.$brand->getId())
                ->save();
    }
}
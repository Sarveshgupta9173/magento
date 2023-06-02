<?php

class Sg_Vendor_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_NODE_VENDOR_PRODUCT_TYPE      = 'global/catalog/product/type/vendor';

    /**
     * Retrieve array of allowed product types for VENDOR selection product
     *
     * @return array
     */
    public function getAllowedSelectionTypes()
    {
        $config = Mage::getConfig()->getNode(self::XML_NODE_VENDOR_PRODUCT_TYPE);
        return array_keys($config->allowed_selection_types->asArray());
    }
}

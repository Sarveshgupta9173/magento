<?php

/**
 * 
 */
class Ccc_Practice_Block_Adminhtml_Nine_Renderer_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract        
{
    
    function render($row)
    {
        $productId = $row->getId();
        $sku = $row->getSku();

        $attributes = Mage::getResourceModel('catalog/product_attribute_collection')
            ->addFieldToFilter('is_user_defined', 1)
            ->getItems();

        foreach ($attributes as $attribute) {
            $attributeCodes[] = $attribute->getAttributeCode();
        }


        foreach ($attributeCodes as $attributeCode) {
            $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
            if (!$attribute->getBackend()->getValue($row)) {
                $unassignedAttributes[] = array(
                    'product_id' => $productId,
                    'sku' => $sku,
                    'attribute_id' => $attribute->getId(),
                    'attribute_code' => $attributeCode
                );
            }
        }
        var_dump($unassignedAttributes);
        // die;
        return $unassignedAttributes;
    }
}

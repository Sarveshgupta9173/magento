<?php
/**
 * 
 */

class Ccc_Practice_Adminhtml_QueryController extends Mage_Adminhtml_Controller_Action
{

    public function oneAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_one'));
        $this->renderLayout();
    }

    public function twoAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_two'));
        $this->renderLayout();
    }

    public function threeAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_three'));
        $this->renderLayout();
    }

    public function fourAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_four'));
        $this->renderLayout();
    }

    public function fiveAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_five'));
        $this->renderLayout();
    }

    public function sixAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_six'));
        $this->renderLayout();
    }

    public function sevenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_seven'));
        $this->renderLayout();
    }

    public function eightAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_eight'));
        $this->renderLayout();
    }

    public function nineAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_nine'));
        $this->renderLayout();
    }

    public function tenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_ten'));
        $this->renderLayout();
    }

    public function viewoneAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $tableName = $resource->getTableName('catalog/product');
        echo "1. Need a list of product with these columns product name, sku, cost, price, color.";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo $select = $readConnection->select()
                ->from(array('p' => $tableName), array(
                    'sku' => 'p.sku',
                    'name' => 'pv.value',
                    'cost' => 'pdc.value',
                    'price' => 'pdp.value',
                    'color' => 'pi.value',
                ))
                ->joinLeft(
                    array('pv' => $resource->getTableName('catalog_product_entity_varchar')),
                    'pv.entity_id = p.entity_id AND pv.attribute_id = 73',
                    array()
                )
                ->joinLeft(
                    array('pdc' => $resource->getTableName('catalog_product_entity_decimal')),
                    'pdc.entity_id = p.entity_id AND pdc.attribute_id = 81',
                    array()
                )
                ->joinLeft(
                    array('pdp' => $resource->getTableName('catalog_product_entity_decimal')),
                    'pdp.entity_id = p.entity_id AND pdp.attribute_id = 77',
                    array()
                )
                ->joinLeft(
                    array('pi' => $resource->getTableName('catalog_product_entity_int')),
                    'pi.entity_id = p.entity_id AND pi.attribute_id = 142',
                    array()
                );;        
        echo "<br>";        
                
        
    }

    public function viewtwoAction()
    {
        echo "2. Need a list of attribute & options. return an array with attribute id, attribute code, option Id, option name.";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo "qew";        
        echo "<br>";        
        echo "sql query :";        
        echo "<br>";        
        echo "SELECT 
            eav_attribute.attribute_id,
            eav_attribute.attribute_code,
            eav_attribute_option_value.option_id,
            eav_attribute_option_value.value AS option_name
        FROM 
            eav_attribute
        INNER JOIN 
            eav_attribute_option ON eav_attribute.attribute_id = eav_attribute_option.attribute_id
        INNER JOIN 
            eav_attribute_option_value ON eav_attribute_option.option_id = eav_attribute_option_value.option_id
        ORDER BY 
            eav_attribute.attribute_id, eav_attribute_option.option_id;
";
        
    }

    public function viewthreeAction()
    {
        echo "3. Need a list of attribute having options count greater than 10. return array with attribute id, attribute code, option count.";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo $collection = Mage::getResourceModel('eav/entity_attribute_collection')
    ->addFieldToFilter('main_table.frontend_input', ['in' => ['select', 'multiselect']])
    ->getSelect()
    ->joinLeft(
        ['options' => Mage::getSingleton('core/resource')->getTableName('eav_attribute_option')],
        'options.attribute_id = main_table.attribute_id',
        ['option_count' => 'COUNT(options.option_id)']
    )
    ->group('main_table.attribute_id')
    ->having('option_count > ?', 10);

$attributeList = $collection->getConnection()->fetchAll($collection);
;        
        echo "<br>";        
        echo "<br>";        
        echo "sql query :";        
        echo "<br>";        
        echo "SELECT
    eav_attribute.attribute_id,
    eav_attribute.attribute_code,
    COUNT(eav_attribute_option.option_id) AS option_count
FROM
    eav_attribute
INNER JOIN
    eav_attribute_option ON eav_attribute.attribute_id = eav_attribute_option.attribute_id
GROUP BY
    eav_attribute.attribute_id
HAVING
    option_count > 10;
";
        
    }

    public function viewfourAction()
    {
        echo "4. Need list of product with assigned images. return an array with product Id, sku, base image, thumb image, small image.";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo "TESTING....";        
        echo "<br>";        
        echo "sql query :";        
        echo "<br>";        
        echo "SELECT 
    p.entity_id AS product_id,
    p.sku,
    bi.value AS base_image,
    ti.value AS thumb_image,
    si.value AS small_image
FROM 
    catalog_product_entity AS p
LEFT JOIN 
    catalog_product_entity_varchar AS bi ON p.entity_id = bi.entity_id
    AND bi.attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'image')
LEFT JOIN 
    catalog_product_entity_varchar AS ti ON p.entity_id = ti.entity_id
    AND ti.attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'thumbnail')
LEFT JOIN 
    catalog_product_entity_varchar AS si ON p.entity_id = si.entity_id
    AND si.attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'small_image');

";
        
    }

    public function viewfiveAction()
    {
        echo "5. Need list of product with gallery image count. return an array with product sku, gallery images count, without consideration of thumb, small, base";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo "qew";        
        echo "<br>";        
        echo "sql query :";        
        echo "<br>";        
        // echo "dewfwehf";
        
    }

    public function viewsixAction()
    {
        echo "6. Need list of top to bottom customers with their total order counts. return an array with customer id, customer name, customer email, order count.";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo "qew";        
        echo "<br>";        
        echo "sql query :";        
        echo "<br>";        
        echo "dewfwehf";
        
    }

    public function viewsevenAction()
    {
        echo "7. Need list of top to bottom customers with their total order counts, order status wise. return an array with customer id, customer name, customer email, status, order count.";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo "qew";        
        echo "<br>";        
        echo "sql query :";        
        echo "<br>";        
        echo "dewfwehf";
        
    }

    public function vieweightAction()
    {
        echo "8. Need list product with number of quantity sold till now for each. return an array with product id, sku, sold quantity.";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo "qew";        
        echo "<br>";        
        echo "sql query :";        
        echo "<br>";        
        echo "dewfwehf";
        
    }

    public function viewnineAction()
    {
        echo "9. Need list of those attributes for whose value is not assigned to product. return an array result product wise with these columns product Id, sku, attribute Id, attribute code";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo "qew";        
        echo "<br>";        
        echo "sql query :";        
        echo "<br>";        
        echo "dewfwehf";

        echo "query nine";
        echo "<br>";
         $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('sku');

       $attributes = Mage::getResourceModel('catalog/product_attribute_collection')
            ->addFieldToFilter('is_user_defined', 1)
            ->getItems();

        foreach ($attributes as $attribute) {
            $attributeCodes[] = $attribute->getAttributeCode();
        }

        $unassignedAttributes = array();

        $products = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku');


        foreach ($products as $product) {
            $productId = $product->getId();
            $sku = $product->getSku();

            foreach ($attributeCodes as $attributeCode) {
                $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
                $attributeId = $attribute->getId();

                $resource = Mage::getResourceModel('catalog/product');
                $value = $resource->getAttributeRawValue($productId, $attributeCode, Mage::app()->getStore());

                if ($value === false || $value === null) {
                    $unassignedAttributes[] = array(
                        'product_id' => $productId,
                        'sku' => $sku,
                        'attribute_id' => $attributeId,
                        'attribute_code' => $attributeCode
                    );
                }
            }
        }
        echo "<pre>";
        print_r($unassignedAttributes);
        die;
        
    }

    public function viewtenAction()
    {
        echo "10. Need list of those attributes for whose value is not assigned to product. return an array result product wise with these columns product Id, sku, attribute Id, attribute code, value.";
        echo "<br>";        
        echo "magento query :";        
        echo "<br>";        
        echo "qew";        
        echo "<br>";        
        echo "sql query :";        
        echo "<br>";        
        echo "dewfwehf";
        
    }


    
}
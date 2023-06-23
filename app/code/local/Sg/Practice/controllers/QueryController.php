<?php

class Ccc_Practice_QueryController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        // echo "<pre>";
        // $resource = Mage::getSingleton('core/resource');
        // $write = $resource->getConnection('core_write');
        // $table = $resource->getTableName('product/product');
        // $table2 = $resource->getTableName('idx/idx');

        // $write->insert(
        //     $table, 
        //     ['sku' => 'ABCD', 'cost' => 200]
        // );

        // echo $select = $write->select()
        //     ->from(['tbl' => $table], ['product_id', 'sku'])
        //     ->joinLeft(['tbl2' => $table2], 'tbl.product_id = tbl2.product_id', ['sku']);   
            // ->group('cost')
            // ->where('name LIKE ?', "%{$name}%")
        // $results = $write->fetchAll($select);

        // $write->update(
        //     $table,
        //     ['sku' => 'ABCSD', 'cost' => 5000],
        //     ['product_id = ?' => 12]
        // );


        //Delete:

        // $write->delete(
        //     $table,
        //     ['product_id IN (?)' => [25, 32]]
        // );


        //Insert Multiple:

        // $rows = [
        //     ['sku'=>'value1', 'cost'=>'value2', 'price'=>'value3'],
        //     ['sku'=>'value3', 'cost'=>'value4', 'price'=>'value5'],
        // ];
        // $write->insertMultiple($table, $rows);


        //Insert Update On Duplicate:

        // $data = [];
        // $data[] = [
        //     'sku' => 'BGSDGH',
        //     'cost' => 50000
        // ];

        // $write->insertOnDuplicate(
        //     $table,
        //     $data, // Could also be an array of rows like insertMultiple
        //     ['cost'] // this is the fields that will be updated in case of duplication
        // );

        die;
    }

    public function firstAction()
    {
        // Need a list of product with these columns product name, sku, cost, price, color.
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_first'));
        $this->renderLayout();
    }

    public function firstQueryAction()
    {
        // Retrieve the resource model
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $tableName = $resource->getTableName('catalog/product');
        $select = $readConnection->select()
            ->from(array('p' => $tableName), array(
                'sku' => 'p.sku',
                'name' => 'ov.value',
                'price' => 'a.value',
                'cost' => 'b.value',
                'color' => 'c.value',
            ))
            ->joinLeft(
                array('ov' => $resource->getTableName('catalog_product_entity_varchar')),
                'ov.entity_id = p.entity_id AND ov.attribute_id = 73',
                array()
            )
            ->joinLeft(
                array('a' => $resource->getTableName('catalog_product_entity_decimal')),
                'a.entity_id = p.entity_id AND a.attribute_id = 77',
                array()
            )
            ->joinLeft(
                array('b' => $resource->getTableName('catalog_product_entity_decimal')),
                'b.entity_id = p.entity_id AND b.attribute_id = 81',
                array()
            )
            ->joinLeft(
                array('c' => $resource->getTableName('catalog_product_entity_int')),
                'c.entity_id = p.entity_id AND c.attribute_id = 94',
                array()
            );

        echo $select;die;

        $results = $readConnection->fetchAll($select);

        // Process the results
        foreach ($results as $row) {
            $sku = $row['sku'];
            $productName = $row['name'];
            $cost = $row['cost'];
            $price = $row['price'];
            $color = $row['color'];

            // Print or process the retrieved data as desired
            echo "SKU: $sku, Name: $productName, Cost: $cost, Price: $price, Color: $color\n";
        }
    }

    public function secondAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_second'));
        $this->renderLayout();
    }
    
    public function secondQueryAction()
    {
        $attributeOptions = [];

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $attributeOptionTable = $resource->getTableName('eav_attribute_option');
        $attributeTable = $resource->getTableName('eav_attribute');

        $select = $readConnection->select()
            ->from(
                array('ao' => $attributeOptionTable),
                array(
                    'attribute_id' => 'ao.attribute_id',
                    'option_id' => 'ao.option_id',
                    'option_name' => 'ov.value',
                )
            )
            ->joinLeft(
                array('ov' => $resource->getTableName('eav_attribute_option_value')),
                'ov.option_id = ao.option_id',
                array()
            )
            ->join(
                array('a' => $attributeTable),
                'a.attribute_id = ao.attribute_id',
                array('attribute_code' => 'a.attribute_code')
            );

        $queryResult = $readConnection->fetchAll($select);

        foreach ($queryResult as $row) {
            $attributeOptions[] = array(
                'attribute_id' => $row['attribute_id'],
                'attribute_code' => $row['attribute_code'],
                'option_id' => $row['option_id'],
                'option_name' => $row['option_name'],
            );
        }

        return $attributeOptions;

    }

}

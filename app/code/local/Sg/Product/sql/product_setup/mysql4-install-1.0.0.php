<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('product')};
CREATE TABLE {$this->getTable('product')} (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` bigint(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE {$this->getTable('product')}
  ADD PRIMARY KEY (`product_id`);

ALTER TABLE {$this->getTable('product')}
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

");

$installer->endSetup();
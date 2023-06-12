<?php



$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('vendor')};
CREATE TABLE {$this->getTable('vendor')} (
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updates_at` datetime NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE {$this->getTable('vendor')}
  ADD PRIMARY KEY (`vendor_id`);

ALTER TABLE {$this->getTable('vendor')}
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

");

$installer->endSetup();
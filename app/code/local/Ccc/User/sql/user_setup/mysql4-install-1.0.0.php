<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('user')};
CREATE TABLE {$this->getTable('user')} (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` bigint(20) NOT NULL,
  `password` varchar(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE {$this->getTable('user')}
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE {$this->getTable('user')}
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

");

$installer->endSetup();
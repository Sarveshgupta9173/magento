<?php
$installer = $this;

$installer->startSetup();
$installer->run("
ALTER TABLE `brand` ADD `banner` VARCHAR(255) NOT NULL AFTER `description`, ADD `status` TINYINT(2) NOT NULL AFTER `banner`, ADD `sort_order` INT NOT NULL DEFAULT '0' AFTER `status`, ADD `url_key` VARCHAR(255) NOT NULL AFTER `sort_order`;
    
");

$installer->endSetup();
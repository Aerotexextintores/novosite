<?php

$installer = $this;

$installer->installEntities();

$entityTypeId = $installer->getEntityTypeId('catalog_category');
$attributeSetId = $installer->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $installer->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$installer->addAttributeToSet($entityTypeId, $attributeSetId, $attributeGroupId, 'subcategoryview', '2');


?>
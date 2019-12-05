<?php
/**
 * @author    Louis Bataillard <info@mobweb.ch>
 * @package    MobWeb_Voucher
 * @copyright    Copyright (c) MobWeb GmbH (https://mobweb.ch)
 */

$installer = $this;

$installer->startSetup();

// Create the new attribute
$attributeCode = MobWeb_Voucher_Helper_Product::VOUCHER_ATTRIBUTE_CODE;

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
    'group' => 'General',
    'type' => 'int',
    'label' => 'Product is voucher?',
    'input' => 'select',
    'source' => 'eav/entity_attribute_source_boolean',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => false,
    'required' => false,
    'user_defined' => false,
    'default' => '',
    'apply_to' => 'simple,configurable,grouped,bundle',
    'input_renderer' => '',
    'visible_on_front' => false,
    'used_in_product_listing' => false
));

// Add the attribute to all attribute sets
foreach($installer->getAllAttributeSetIds(Mage_Catalog_Model_Product::ENTITY) as $attributeSetId) {
    $groupId = $installer->getAttributeGroupId(Mage_Catalog_Model_Product::ENTITY, $attributeSetId, 'General');
    $installer->addAttributeToSet(Mage_Catalog_Model_Product::ENTITY, $attributeSetId, $groupId, $attributeCode);
}

$installer->endSetup();
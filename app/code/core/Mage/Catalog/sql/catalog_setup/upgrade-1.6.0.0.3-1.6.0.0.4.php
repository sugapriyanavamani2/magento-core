<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

$installer = $this;
/** @var $installer Mage_Catalog_Model_Resource_Setup */

$installer->updateAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'msrp_enabled',
    'source_model',
    'catalog/product_attribute_source_msrp_type_enabled'
);

$installer->updateAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'msrp_enabled',
    'default_value',
    Mage_Catalog_Model_Product_Attribute_Source_Msrp_Type_Enabled::MSRP_ENABLE_USE_CONFIG
);

$installer->updateAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'msrp_display_actual_price_type',
    'source_model',
    'catalog/product_attribute_source_msrp_type_price'
);

$installer->updateAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'msrp_display_actual_price_type',
    'default_value',
    Mage_Catalog_Model_Product_Attribute_Source_Msrp_Type_Price::TYPE_USE_CONFIG
);

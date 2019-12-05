<?php

/**
 * @author    Louis Bataillard <info@mobweb.ch>
 * @package    MobWeb_Voucher
 * @copyright    Copyright (c) MobWeb GmbH (https://mobweb.ch)
 */
class MobWeb_Voucher_Helper_Product extends Mage_Core_Helper_Abstract
{
    const VOUCHER_ATTRIBUTE_CODE = 'is_voucher';

    /**
     * Returns whether the product is a voucher
     *
     * @param Mage_Catalog_Model_Product $product
     * @return Boolean
     */
    public function getIsVoucher(Mage_Catalog_Model_Product $product)
    {
        $isVoucher = $product->getData(self::VOUCHER_ATTRIBUTE_CODE);

        return (Boolean) $isVoucher;
    }
}
<?php

/**
 * @author    Louis Bataillard <info@mobweb.ch>
 * @package    MobWeb_Voucher
 * @copyright    Copyright (c) MobWeb GmbH (https://mobweb.ch)
 */
class MobWeb_Voucher_Helper_Quoteitem extends Mage_Core_Helper_Abstract
{
    /**
     * Validates that all the information required for a voucher is avaialble from the quote item
     *
     * @param Mage_Sales_Model_Quote_Item $item
     * @return Boolean
     */
    public function validateVoucher(Mage_Sales_Model_Quote_Item $item)
    {
        // Get the custom option
        $customOptions = $this->getCustomOptions($item);
        if (!$customOptions) {
            return false;
        }

        // Validate that there is exactly one custom option
        if (count($customOptions) !== 1) {
            return false;
        }

        // Get the amount from the quote item
        $amount = $this->getAmount($item);
        if (!is_numeric($amount)) {
            return false;
        }

        // Validate the minimum amount, which is the product price
        $productPrice = $item->getProduct()->getPrice();
        if ($productPrice > $amount) {
            return false;
        }

        return true;
    }

    /**
     * Returns the custom options as specified when adding the item to the cart
     *
     * @param Mage_Sales_Model_Quote_Item $item
     * @return Array|Boolean
     */
    public function getCustomOptions(Mage_Sales_Model_Quote_Item $item)
    {
        if ($item instanceof Mage_Sales_Model_Order_Item) {
            $productOptions = $item->getProductOptions();
            $customOptions = $productOptions['options'];
        } else {
            $customOptions = Mage::helper('catalog/product_configuration')->getCustomOptions($item);
        }

        if ($customOptions && is_array($customOptions) && count($customOptions)) {
            return $customOptions;
        }

        return false;
    }

    /**
     * Returns the amount from the quote item
     *
     * @return Double $amount
     */
    public function getAmount(Mage_Sales_Model_Quote_Item $item)
    {
        $customOptions = $this->getCustomOptions($item);
        $amount = $customOptions[0]['value'];

        return $amount;
    }
}
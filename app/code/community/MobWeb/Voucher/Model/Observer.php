<?php

/**
 * @author    Louis Bataillard <info@mobweb.ch>
 * @package    MobWeb_Voucher
 * @copyright    Copyright (c) MobWeb GmbH (https://mobweb.ch)
 */
class MobWeb_Voucher_Model_Observer
{

    /**
     * After adding a product to the cart, check if it's a voucher. If it is, validate the amount entered by the customer
     * and throw an exception if the amount is invalid or missing
     *
     * @param Varien_Event_Observer $event
     * @throws Exception
     */
    public function checkoutCartProductAddAfter(Varien_Event_Observer $event)
    {
        $productHelper = Mage::helper('mobweb_voucher/product');
        $quoteItemHelper = Mage::helper('mobweb_voucher/quoteitem');

        /** @var $item Mage_Sales_Model_Quote_Item */
        $item = $event->getQuoteItem();
        if ($item && $item instanceof Mage_Sales_Model_Quote_Item) {

            // Validate that the product added to the cart is a voucher product
            $product = $item->getProduct();
            $productIsVoucher = $productHelper->getIsVoucher($product);
            if ($productIsVoucher) {

                // Validate the voucher
                $validateVoucher = $quoteItemHelper->validateVoucher($item);
                if (!$validateVoucher) {
                    throw Mage::exception('Mage_Core', $productHelper->__('Unable to add voucher to cart, please try again.'));
                }

                // Get the amount entered (validation of the amount is already done above)
                $amount = $quoteItemHelper->getAmount($item);

                // Set the amount as the price of the quote item
                $item->setCustomPrice($amount);
                $item->setOriginalCustomPrice($amount);
                $item->getProduct()->setIsSuperMode(true);
            }
        }
    }
}
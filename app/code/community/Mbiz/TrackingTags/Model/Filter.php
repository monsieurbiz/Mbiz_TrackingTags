<?php
/**
 * This file is part of Mbiz_TrackingTags for Magento.
 *
 * @license All rights reserved
 * @author Jacques Bodin-Hullin <j.bodinhullin@monsieurbiz.com> <@jacquesbh>
 * @category Mbiz
 * @package Mbiz_TrackingTags
 * @copyright Copyright (c) 2014 Monsieur Biz (http://monsieurbiz.com/)
 */

/**
 * Filter Model
 * @package Mbiz_TrackingTags
 */
class Mbiz_TrackingTags_Model_Filter extends Mage_Core_Model_Email_Template_Filter
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * @return string
     */
    public function productDirective($construction)
    {
        // This directive only works if we have a product!
        if (!$product = Mage::registry('product')) {
            $product = Mage::registry('current_product');
        }

        if (is_object($product) && $product->getId()) {
            $params   = $this->_getIncludeParameters($construction[2]);
            // Only if we have an attribute
            if (isset($params['attr']) || isset($params['attribute'])) {
                $attr = isset($params['attr']) ? $params['attr'] : $params['attribute'];
                return $product->getDataUsingMethod($attr);
            }
        }

        return '';
    }

    /**
     * @return string
     */
    public function categoryDirective($construction)
    {
        // This directive only works if we have a category!
        if (!$category = Mage::registry('category')) {
            $category = Mage::registry('current_category');
        }

        if (is_object($category) && $category->getId()) {
            $params   = $this->_getIncludeParameters($construction[2]);
            // Only if we have an attribute
            if (isset($params['attr']) || isset($params['attribute'])) {
                $attr = isset($params['attr']) ? $params['attr'] : $params['attribute'];
                return Mage::helper('core')->jsQuoteEscape($category->getDataUsingMethod($attr), '\'');
            }
        }

        return '';
    }

    /**
     * @return string
     */
    public function customerDirective($construction)
    {
        $params   = $this->_getIncludeParameters($construction[2]);

        // Attribute?
        if (isset($params['attr']) || isset($params['attribute'])) {
            $attr = isset($params['attr']) ? $params['attr'] : $params['attribute'];
            $customer = Mage::helper('customer')->getCustomer();
            return Mage::helper('core')->jsQuoteEscape($customer->getDataUsingMethod($attr), '\'');
        }

        return '';
    }

    /**
     * @return string
     */
    public function cartDirective($construction)
    {
        $params   = $this->_getIncludeParameters($construction[2]);

        $cart = Mage::helper('checkout/cart')->getCart();

        // Attribute?
        if (isset($params['attr']) || isset($params['attribute'])) {
            $attr = isset($params['attr']) ? $params['attr'] : $params['attribute'];
            return Mage::helper('core')->jsQuoteEscape($cart->getDataUsingMethod($attr), '\'');
        }

        // Items?
        if (isset($params['items'])) {
            $attributes = explode(',', $params['items']);
            $_items = array();
            foreach ($cart->getItems() as $item) {
                $_item = array();
                foreach ($attributes as $attr) {
                    $_item[$attr] = $item->getDataUsingMethod($attr);
                }
                $_items[] = $_item;
                unset($_item);
            }
            return Mage::helper('core')->jsonEncode($_items);
        }

        return '';
    }

    /**
     * @return string
     */
    public function quoteDirective($construction)
    {
        $params   = $this->_getIncludeParameters($construction[2]);

        $quote = Mage::helper('checkout/cart')->getCart()->getQuote();

        // Attribute?
        if (isset($params['attr']) || isset($params['attribute'])) {
            $attr = isset($params['attr']) ? $params['attr'] : $params['attribute'];
            return Mage::helper('core')->jsQuoteEscape($quote->getDataUsingMethod($attr), '\'');
        }

        return '';
    }

    /**
     * @return string
     */
    public function lastorderDirective($construction)
    {
        $params   = $this->_getIncludeParameters($construction[2]);

        // Only if we have an order
        if ($order = Mage::helper('mbiz_trackingtags')->getLastOrder()) {

            // Attribute?
            if (isset($params['attr']) || isset($params['attribute'])) {
                $attr = isset($params['attr']) ? $params['attr'] : $params['attribute'];
                return Mage::helper('core')->jsQuoteEscape($order->getDataUsingMethod($attr), '\'');
            }

            // Items?
            if (isset($params['items'])) {
                $attributes = explode(',', $params['items']);
                $_items = array();
                foreach ($order->getAllVisibleItems() as $item) {
                    $_item = array();
                    foreach ($attributes as $attr) {
                        $_item[$attr] = $item->getDataUsingMethod($attr);
                    }
                    $_items[] = $_item;
                    unset($_item);
                }
                return Mage::helper('core')->jsonEncode($_items);
            }
        }

        return '';
    }

    /**
     * @return string
     */
    public function pageDirective($construction)
    {
        $page = Mage::getSingleton('cms/page'); // @see Mage_Cms_Helper_Page::_renderPage()

        if (!$page || !$page->getPageId()) {
            return '';
        }

        $params   = $this->_getIncludeParameters($construction[2]);

        // Attribute?
        if (isset($params['attr']) || isset($params['attribute'])) {
            $attr = isset($params['attr']) ? $params['attr'] : $params['attribute'];
            return Mage::helper('core')->jsQuoteEscape($page->getDataUsingMethod($attr), '\'');
        }

        return '';
    }

// Monsieur Biz Tag NEW_METHOD

}
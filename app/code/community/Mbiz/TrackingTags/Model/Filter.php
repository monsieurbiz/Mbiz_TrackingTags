<?php
/**
 * This file is part of Mbiz_TrackingTags for Magento.
 *
 * @license MIT
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
     * The number of orders for the customer
     *
     * @var int
     */
    protected $_customerOrders;

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

                $data = $category->getDataUsingMethod($attr);

                if ($attr == Mbiz_TrackingTags_Model_Config::CATEGORY_URL_KEY_ATTRIBUTE_CODE && Mage::getEdition() == Mage::EDITION_ENTERPRISE) {
                    $data = $this->_getEnterpriseUrlKey($category);
                }

                return Mage::helper('core')->jsQuoteEscape($data, '\'');
            }
        }

        return '';
    }

    /**
     * Get URL key for Enterprise
     *
     * @param Mage_Catalog_Model_Category $category
     * @return mixed
     */
    protected function _getEnterpriseUrlKey(Mage_Catalog_Model_Category $category)
    {
        $resource = Mage::getSingleton('core/resource');
        $conn = $resource->getConnection('core_read');
        $tableName = $resource->getTableName(array('catalog/category', 'url_key'));
        $select = $conn->select()
            ->from(
                array('url_key_table' => $tableName),
                array('url_key' => 'url_key_table.value', 'store_id' => 'MAX(url_key_table.store_id)')
            )
            ->where('url_key_table.entity_id = ?', $category->getId())
            ->where('url_key_table.store_id IN(?)', array(Mage_Core_Model_App::ADMIN_STORE_ID, $category->getStoreId()))
        ;

        $row = $conn->fetchRow($select);

        return $row['url_key'];
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

            // Manage the number of orders for the customer
            if ($attr == 'orders_count') {
                if ($this->_customerOrders !== null) {
                    return $this->_customerOrders;
                }
                if ($customer->getId()) {
                    $customerOrders = Mage::getResourceModel('sales/order_collection')
                        ->addFieldToFilter('customer_id', array('eq' => $customer->getId()));

                    $this->_customerOrders = $customerOrders->getSize();
                } else {
                    $this->_customerOrders = 1;
                }
                return $this->_customerOrders;
            }
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

// Monsieur Biz Tag NEW_METHOD

}
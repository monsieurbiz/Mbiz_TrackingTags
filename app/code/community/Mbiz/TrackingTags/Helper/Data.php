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
 * Data Helper
 * @package Mbiz_TrackingTags
 */
class Mbiz_TrackingTags_Helper_Data extends Mage_Core_Helper_Abstract
{

// Monsieur Biz Tag NEW_CONST

    /**
     * The last order
     * @var null|Mage_Sales_Model_Order
     */
    protected $_lastOrder;

// Monsieur Biz Tag NEW_VAR

    /**
     * Retrieve if a tag is activated or not
     * @param string $identifier The tag identifier
     * @return bool
     */
    public function isTagActive($identifier)
    {
        return Mage::getSingleton('mbiz_trackingtags/config')->isTagActive(
            $identifier,
            Mage::app()->getStore()->getId()
        );
    }

    /**
     * Retrieve the tracking tag saved in configuration with search and replace.
     * @param string $identifier The tag identifier
     * @return string The tracking tag
     */
    public function getTrackingTag($identifier)
    {
        $filter = Mage::getModel('mbiz_trackingtags/filter');
        return $filter->filter(Mage::getSingleton('mbiz_trackingtags/config')->getTrackingTag(
            $identifier,
             Mage::app()->getStore()->getId()
        ));
    }

    /**
     * Retrieve the last order (in checkout/onepage/success)
     * @return Mage_Sales_Model_Order
     */
    public function getLastOrder()
    {
        if (!$this->_lastOrder) {
            $orderId = Mage::getSingleton('checkout/session')->getLastOrderId();
            if ($orderId) {
                $order = Mage::getModel('sales/order')->load($orderId);
                if ($order->getId()) {
                    $this->_lastOrder = $order;
                }
            }
        }
        return $this->_lastOrder;
    }

// Monsieur Biz Tag NEW_METHOD

}
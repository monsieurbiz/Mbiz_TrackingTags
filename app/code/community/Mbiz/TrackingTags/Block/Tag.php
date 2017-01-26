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
 * Tag Block
 * @package Mbiz_TrackingTags
 *
 * @method Mbiz_TrackingTags_Block_Tag setTagIdentifier(string $identifier) Set the tag identifier
 * @method string getTagIdentifier() Retrieve the tag identifier
 * @method bool hasTagIdentifier() Retrieve if the tag identifier is set or not
 */
class Mbiz_TrackingTags_Block_Tag extends Mage_Core_Block_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * To HTML
     * @return string
     */
    protected function _toHtml()
    {
        $helper = Mage::helper('mbiz_trackingtags');
        if ($this->hasTagIdentifier() && $helper->isTagActive($this->getTagIdentifier())) {
            return $helper->getTrackingTag($this->getTagIdentifier());
        }

        return '';
    }

// Monsieur Biz Tag NEW_METHOD

}

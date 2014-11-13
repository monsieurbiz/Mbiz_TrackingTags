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
 * Config Model
 * @package Mbiz_TrackingTags
 */
class Mbiz_TrackingTags_Model_Config extends Mage_Core_Model_Abstract
{

    /**
     * Identifier for "generic" tag
     */
    const GENERIC_TAG_IDENTIFIER = 'generic';

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Retrieve if a tag is activated or not
     * @param string $identifier The tag identifier
     * @param int|null $store The store ID, or NULL to get the current store
     * @return bool
     */
    public function isTagActive($identifier, $store = null)
    {
        return Mage::getStoreConfigFlag(
            sprintf(
                'design/mbiz_trackingtags/%s_active',
                $identifier
            ),
            $store
        );
    }

    /**
     * Retrieve the tracking tag of the identifier
     * @param string $identifier The tag identifier
     * @param int|null $store The store ID, or NULL to get the current store
     * @return string
     */
    public function getTrackingTag($identifier, $store = null)
    {
        return Mage::getStoreConfig(
            sprintf(
                'design/mbiz_trackingtags/%s_tag',
                $identifier
            ),
            $store
        );
    }

    /**
     * Check if given uri is in generic uri config
     *
     * @param string $checkedUri
     * @return bool
     */
    public function isGenericTagUri($checkedUri)
    {
        $uriCollection = Mage::getStoreConfig('design/mbiz_trackingtags/generic_uri_collection');
        $uriCollection = explode("\n", $uriCollection);


        foreach ($uriCollection as $k => $uri) {
            $uri = trim($uri);
            if ($uri === '') {
                unset($uriCollection[$k]);
            }
            else {
                $uriCollection[$k] = $uri;
            }
        }

        return in_array($checkedUri, $uriCollection);
    }

// Monsieur Biz Tag NEW_METHOD

}
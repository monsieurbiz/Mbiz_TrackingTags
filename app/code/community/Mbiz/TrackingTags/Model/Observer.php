<?php
/**
 * This file is part of Mbiz_TrackingTags for Magento.
 *
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author Hervé Guétin <herve.guetin@agence-soon.fr> <@herveguetin>
 * @category Mbiz
 * @package Mbiz_TrackingTags
 * @copyright Copyright (c) 2014 Agence Soon (http://www.agence-soon.fr)
 */

/**
 * Observer Model
 * @package Mbiz_TrackingTags
 */
class Mbiz_TrackingTags_Model_Observer
{

// Agence Soon Tag NEW_CONST

// Agence Soon Tag NEW_VAR

    /**
     * Add generic tag if required
     */
    public function addGenericTag()
    {
        if (Mage::helper('mbiz_trackingtags')->hasGenericTag()) {
            /* @var $layoutUpdate Mage_Core_Model_Layout_Update */
            $layoutUpdate = Mage::app()->getLayout()->getUpdate();
            $layoutUpdate->addHandle('mbiz_trackingtags_generic');
        }
    }

// Agence Soon Tag NEW_METHOD

}
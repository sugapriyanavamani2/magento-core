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
 * @category    Enterprise
 * @package     Enterprise_Index
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Index adminhtml notifications block
 *
 * @category    Enterprise
 * @package     Enterprise_Index
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Enterprise_Index_Block_Adminhtml_Notifications
    extends Mage_Index_Block_Adminhtml_Notifications
{
    /**
     * Get array of index names which require data reindex
     *
     * @return array
     */
    public function getProcessesForReindex()
    {
        $res = array();

        /** @var $collection  Enterprise_Index_Model_Resource_Process_Collection */
        $collection = Mage::getResourceModel('enterprise_index/process_collection');
        $collection->initializeSelect();

        /** @var $process Enterprise_Index_Model_Process */
        foreach ($collection as $process) {
            if ($process->isEnterpriseProcess()) {
                continue;
            }
            if (($process->getStatus() == Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX
                || $process->getEvents()) && $process->getIndexer()->isVisible()
            ) {
                $res[] = $process->getIndexer()->getName();
            }
        }

        return $res;
    }
}

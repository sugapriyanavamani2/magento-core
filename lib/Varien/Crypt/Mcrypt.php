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
 * @category    Varien
 * @package     Varien_Crypt
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */


/**
 * Mcrypt plugin
 *
 * @category   Varien
 * @package    Varien_Crypt
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Varien_Crypt_Mcrypt extends Varien_Crypt_Abstract
{
    /**
     * Constuctor
     *
     * @param array $data
     */
    public function __construct(array $data=array())
    {
        parent::__construct($data);
    }

    /**
     * Initialize mcrypt module
     *
     * @param string $key cipher private key
     * @return Varien_Crypt_Mcrypt
     */
    public function init($key)
    {
        if (!$this->getCipher()) {
            $this->setCipher(MCRYPT_BLOWFISH);
        }

        if (!$this->getMode()) {
            $this->setMode(MCRYPT_MODE_ECB);
        }

        $this->setHandler(mcrypt_module_open($this->getCipher(), '', $this->getMode(), ''));

        if (!$this->getInitVector()) {
            if (MCRYPT_MODE_CBC == $this->getMode()) {
                $this->setInitVector(substr(
                    md5(mcrypt_create_iv (mcrypt_enc_get_iv_size($this->getHandler()), MCRYPT_RAND)),
                    - mcrypt_enc_get_iv_size($this->getHandler())
                ));
            } else {
                $this->setInitVector(mcrypt_create_iv (mcrypt_enc_get_iv_size($this->getHandler()), MCRYPT_RAND));
            }
        }

        $maxKeySize = mcrypt_enc_get_key_size($this->getHandler());

        if (strlen($key) > $maxKeySize) { // strlen() intentionally, to count bytes, rather than characters
            $this->setHandler(null);
            throw new Varien_Exception('Maximum key size must be smaller '.$maxKeySize);
        }

        mcrypt_generic_init($this->getHandler(), $key, $this->getInitVector());

        return $this;
    }

    /**
     * Encrypt data
     *
     * @param string $data source string
     * @return string
     */
    public function encrypt($data)
    {
        if (!$this->getHandler()) {
            throw new Varien_Exception('Crypt module is not initialized.');
        }
        if (strlen($data) == 0) {
            return $data;
        }
        return mcrypt_generic($this->getHandler(), $data);
    }

    /**
     * Decrypt data
     *
     * @param string $data encrypted string
     * @return string
     */
    public function decrypt($data)
    {
        if (!$this->getHandler()) {
            throw new Varien_Exception('Crypt module is not initialized.');
        }
        if (strlen($data) == 0) {
            return $data;
        }
        return mdecrypt_generic($this->getHandler(), $data);
    }

    /**
     * Desctruct cipher module
     *
     */
    public function __destruct()
    {
        if ($this->getHandler()) {
            $this->_reset();
        }
    }

    protected function _reset()
    {
        mcrypt_generic_deinit($this->getHandler());
        mcrypt_module_close($this->getHandler());
    }
}

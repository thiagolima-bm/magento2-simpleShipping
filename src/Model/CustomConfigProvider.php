<?php
/**
 * Acaldeira_SimpleShipping
 *
 * @category    Acaldeira
 * @package     Acaldeira_Shipping
 * @copyright   Copyright (c) 2017 Acaldeira. (http://www.acaldeira.com.br)
 */

namespace Acaldeira\SimpleShipping\Model;

use \Magento\Checkout\Model\ConfigProviderInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Store\Model\StoreManagerInterface;

class CustomConfigProvider implements ConfigProviderInterface
{

    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * CustomConfigProvider constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager

    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $config = [
            'shipping' => [
                'simpleShipping' => [
                    'message' => $this->getConfigData('message'),
                ]
            ]
        ];
        return $config;
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getConfigData($field)
    {
        $storeId = $this->_storeManager->getStore()->getId();
        $path = 'carriers/simple_shipping/' . $field;
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }
}
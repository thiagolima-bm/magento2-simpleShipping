<?php
/**
 * Acaldeira_SimpleShipping
 *
 * @category    Acaldeira
 * @package     Acaldeira_Shipping
 * @copyright   Copyright (c) 2017 Acaldeira. (http://www.acaldeira.com.br)
 */

namespace Acaldeira\SimpleShipping\Model\Carrier;

use \Magento\Shipping\Model\Carrier\AbstractCarrier;
use \Magento\Shipping\Model\Carrier\CarrierInterface;
use \Magento\Quote\Model\Quote\Address\RateRequest;
use \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use \Magento\Shipping\Model\Rate\ResultFactory;
use \Psr\Log\LoggerInterface;
use \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class Method extends AbstractCarrier implements CarrierInterface {

    /**
     * @var string
     */
    protected $_code = 'simple_shipping';

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    protected $_rateResultFactory;

    /**
     * Method constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * Collect and get rates
     *
     * @param RateRequest $request
     * @return \Magento\Framework\DataObject|bool|null
     * @api
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        /** @var Result $result */
        $result = $this->_rateResultFactory->create();

        $shippingPrice = $this->getShippingPrice($request);

        if ($shippingPrice !== false) {
            $method = $this->createResultMethod($shippingPrice);
            $result->append($method);
        }

        return $result;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->getCarriepelrCode() => $this->getConfigData('name')];
    }

    /**
     * @param int|float $shippingPrice
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Method
     */
    private function createResultMethod($shippingPrice)
    {
        /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
        $method = $this->_rateMethodFactory->create();

        $method->setCarrier($this->getCarrierCode());
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->getCarrierCode());
        $method->setMethodTitle($this->getConfigData('name'));

        $method->setPrice($shippingPrice);
        $method->setCost($shippingPrice);
        return $method;
    }

    /**
     * @param RateRequest $request
     * @return false|float|string|void
     */
    private function getShippingPrice(RateRequest $request)
    {
        $configPrice = $this->getConfigData('price');
        $shippingPrice =  ($configPrice) ? $configPrice : '0.0';
        return $shippingPrice;
    }
}
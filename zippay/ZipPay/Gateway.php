<?php
namespace Omnipay\ZipPay;

use Omnipay\Common\AbstractGateway;
use zipMoney\Configuration;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'ZipPay';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantID' => '',
            'merchantKey' => '',
            'testMode' => false,
        );
    }

    public function setMerchantID($merchantID)
    {
        return $this->setParameter('merchant_id', $merchantID);
    }

    public function getMerchantID()
    {
        return $this->getParameter('merchant_id');
    }

    public function setMerchantKey($merchantKey)
    {
        return $this->setParameter('merchant_key', $merchantKey);
    }

    public function getMerchantKey()
    {
        return $this->getParameter('merchant_key');
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ZipPay\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ZipPay\Message\CompletePurchaseRequest', $parameters);
    }
}

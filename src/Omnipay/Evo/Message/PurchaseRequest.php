<?php

namespace Omnipay\Evo\Message;

use SimpleXMLElement;
use Omnipay\Common\Message\AbstractRequest;

/**
 * Evo Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    protected $liveTokenUrl = 'vvv'; // @TODO: Need to find out what this is.
    protected $testTokenUrl = 'https://testvpos.boipa.com/pg/token';
    
    protected $liveEndpoint = 'zzz';  // @TODO: This needs to be set.
    protected $testEndpoint = 'https://testvpos.boipa.com:19445/fim/api';
    
    protected $liveRedirectUrl = 'xxx'; // @TODO: Need to find out what this is.
    protected $testRedirectUrl = 'https://testvpos.boipa.com/fim/paymentgate';
    
    protected $merchantType = '3d_pay_hosting';
    
    protected $OrderId;

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }
    
    public function getMerchantType() {
        return $this->merchantType;
    }
    
    public function getOrderId() {
        return $this->OrderId;
    }

    public function getData()
    {

        $this->OrderId = time(); // @TODO: temporary!
        
        return [
            'ClientId' => $this->getMerchantId(),
            'Password' => $this->getPassword(),
            'OrderId' => $this->OrderId,
            'Total' => $this->getAmount(),
            'Currency' => $this->getCurrency(),
        ];
        
    }

    public function getTokenUrl()
    {
        return $this->getTestMode() ? $this->testTokenUrl : $this->liveTokenUrl;
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function getRedirectUrl()
    {
        return $this->getTestMode() ? $this->testRedirectUrl : $this->liveRedirectUrl;
    }

    /**
     * @param SimpleXMLElement $data
     * @return \Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
        // Send the data to the token URL and process the response.
        $tokenResponse = $this->httpClient->post($this->getTokenUrl(), null, $data, ['timeout' => 5])->send();
        $this->response = new Response($this, $tokenResponse->getBody());
        return $this->response;
        
    }
}

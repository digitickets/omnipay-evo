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
        $this->validate('amount', 'card', 'transactionId');
        /**
         * @var Omnipay\Common\CreditCard $card
         */
        $card = $this->getCard();
        $card->validate();

        $this->OrderId = time();
        
        return [
            'ClientId' => $this->getMerchantId(),
            'Password' => $this->getPassword(),
            'OrderId' => $this->OrderId,
            'Total' => $this->getAmount(),
            'Currency' => $this->getCurrency(),
        ];
        
        // @TODO: This lot need to go!
        $data = new SimpleXMLElement('<CC5Request/>');

            $data->Name = $this->getUsername();
            $data->Password = $this->getPassword();
            $data->ClientId = $this->getMerchantId();
            $data->Type = 'PostAuth';
            $data->IPAddress = $this->getClientIP();
            $data->Email = $card->getEmail();
            $data->OrderId = '111111111';
            $data->TransId = $this->getTransactionId();
            $data->Total = $this->getAmount();
            $data->Currency = $this->getCurrency();
            $data->Number = $card->getNumber();
            $data->Expires = $card->getExpiryDate('m/y');
            $data->Cvv2Val = $card->getCvv();
    
            // "Bill To" info.
            $billTo = $data->addChild('BillTo');
            $billTo->Name = $card->getBillingFirstName() . ' ' . $card->getBillingLastName();
            $billTo->Street1 = $card->getBillingAddress1();
            $billTo->Street2 = $card->getBillingAddress2();
            $billTo->City = $card->getBillingCity();
            $billTo->StateProv = $card->getBillingState();
            $billTo->PostalCode = $card->getBillingPostcode();
            $billTo->Country = $card->getBillingCountry();
            $billTo->TelVoice = $card->getBillingPhone();
            
            // The shipping info.
            $ShipTo = $data->addChild('ShipTo');
            $ShipTo->Name = $card->getShippingFirstName() . ' ' . $card->getShippingLastName();
            $ShipTo->Street1 = $card->getShippingAddress1();
            $ShipTo->Street2 = $card->getShippingAddress2();
            $ShipTo->City = $card->getShippingCity();
            $ShipTo->StateProv = $card->getShippingState();
            $ShipTo->PostalCode = $card->getShippingPostcode();
            $ShipTo->Country = $card->getShippingCountry();
            $ShipTo->TelVoice = $card->getShippingPhone();
    
            // @TODO: We'll need access to the order lines!
            $orderItemList = $data->addChild('OrderItemList');
            $orderItem1 = $orderItemList->addChild('OrderItem');
            $orderItem1->ItemNumber = '1';
            $orderItem1->ProductCode = '2';
            $orderItem1->Qty = 3;
            $orderItem1->Desc = '4';
            $orderItem1->Id = '5';
            $orderItem1->Price = '6';
            $orderItem1->Total = '18';
            $orderItem2 = $orderItemList->addChild('OrderItem');
            $orderItem2->ItemNumber = '7';
            $orderItem2->ProductCode = '8';
            $orderItem2->Qty = 9;
            $orderItem2->Desc = '10';
            $orderItem2->Id = '11';
            $orderItem2->Price = '12';
            $orderItem2->Total = '108';
        
        return $data;
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

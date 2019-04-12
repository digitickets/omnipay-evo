<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

use Guzzle\Common\Collection;
use Omnipay\Common\Item;
use SimpleXMLElement;
use Omnipay\Common\Message\AbstractRequest;

/**
 * Three Step Redirect Api Purchase Request
 */
class FormUrlRequest extends AbstractRequest
{
    protected $gatewayURL = 'https://secure.evogateway.com/api/v2/three-step';

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function getData()
    {
        // Initiate Step One: Now that we've collected the non-sensitive payment information, we can combine other order information and build the XML format.
        $sales = new SimpleXMLElement('<sale></sale>');

        // Amount, authentication, and Redirect-URL are typically the bare minimum.
        $sales->addChild('api-key', $this->getApiKey());
        $sales->addChild('redirect-url', $this->getReturnUrl());
        $sales->addChild('amount', $this->getAmount());
        $sales->addChild('ip-address', $this->getClientIp());
        $sales->addChild('currency', $this->getCurrency());

        $billing = $sales->addChild('billing');
        $billing->addChild('first-name', $this->getCard()->getBillingFirstName());
        $billing->addChild('last-name', $this->getCard()->getBillingLastName());
        $billing->addChild('address1', $this->getCard()->getBillingAddress1());
        $billing->addChild('city', $this->getCard()->getBillingCity());
        $billing->addChild('state', $this->getCard()->getBillingState());
        $billing->addChild('postal', $this->getCard()->getBillingPostcode());
//        $billing->addChild('billing-address-email', '??');
        $billing->addChild('country', $this->getCard()->getBillingCountry());
        $billing->addChild('email', $this->getCard()->getEmail());
        $billing->addChild('phone', $this->getCard()->getBillingPhone());
        $billing->addChild('company', $this->getCard()->getBillingCompany());
        $billing->addChild('address2', $this->getCard()->getBillingAddress2());
        $billing->addChild('fax', $this->getCard()->getBillingFax());

        $shipping = $sales->addChild('shipping');
        $shipping->addChild('first-name', $this->getCard()->getShippingFirstName());
        $shipping->addChild('last-name', $this->getCard()->getShippingLastName());
        $shipping->addChild('address1', $this->getCard()->getShippingAddress1());
        $shipping->addChild('city', $this->getCard()->getShippingCity());
        $shipping->addChild('state', $this->getCard()->getShippingState());
        $shipping->addChild('postal', $this->getCard()->getShippingPostcode());
        $shipping->addChild('country', $this->getCard()->getShippingCountry());
        $shipping->addChild('phone', $this->getCard()->getShippingPhone());
        $shipping->addChild('email', $this->getCard()->getEmail());
        $shipping->addChild('company', $this->getCard()->getShippingCompany());
        $shipping->addChild('address2', $this->getCard()->getShippingAddress2());

        // A product for item item in the item bag. There shouldn't be any unexpected items in the bagging area.
        /**
         * @var Item $item
         */
        foreach ($this->getItems() as $item) {
            $product = $sales->addChild('product');
            $product->addChild('description', $item->getDescription());
            $product->addChild('quantity', $item->getQuantity());
            $product->addChild('unit-cost', $item->getPrice());
        }

        return $sales->asXML();
    }

    /**
     * @param SimpleXMLElement $data
     * @return \Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
        // Send the data to the token URL and process the response.
        $formUrlResponse = $this
            ->httpClient
            ->post(
                $this->gatewayURL,
                new Collection(['content-type' => 'text/xml']),
                $data,
                ['timeout' => 5]
            )
            ->send();
        $this->response = new FormUrlResponse($this, (string) $formUrlResponse->getBody());

        return $this->response;
    }
}

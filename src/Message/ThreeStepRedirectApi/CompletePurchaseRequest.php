<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

use Omnipay\Common\Item;
use SimpleXMLElement;

/**
 * Three Step Redirect Api CompletePurchase Request
 */
class CompletePurchaseRequest extends AbstractThreeStepRedirectRequest
{
    public function getData()
    {
        // Initiatse step 3 of the process
        $completePurchase = new SimpleXMLElement('<complete-action></complete-action>');
        $completePurchase->addChild('api-key', $this->getApiKey());
        $completePurchase->addChild('token-id', $this->getToken());

        return $completePurchase->asXML();
    }

    /**
     * @param SimpleXMLElement $data
     * @return \Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
        // Send the data to the token URL and process the response.
        $this->response = new CompletePurchaseResponse(
            $this,
            (string) $this->apiRequest($data)->getBody()
        );

        return $this->response;
    }
}

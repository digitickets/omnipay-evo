<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

use SimpleXMLElement;

class RefundRequest extends AbstractThreeStepRedirectRequest
{
    public function getData()
    {
        $this->checkApiKey();

        // Initiase a refund.
        $refund = new SimpleXMLElement('<refund></refund>');
        $refund->addChild('api-key', $this->getApiKey());
        $refund->addChild('transaction-id', $this->getTransactionReference());
        $refund->addChild('amount', $this->getAmount());

        return $refund->asXML();
    }

    /**
     * @param SimpleXMLElement $data
     * @return \Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
\DigiTickets\Applications\Commands\Personal\Debug::log('Refund request: '.var_export($data, true));
        // Send the data to the token URL and process the response.
        $this->response = new RefundResponse(
            $this,
            (string) $this->apiRequest($data)->getBody()
        );

        return $this->response;
    }
}
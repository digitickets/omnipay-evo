<?php

namespace Omnipay\Evo\Message;

use SimpleXMLElement;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * Evo Complete Purchase Request
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
die('Complete Purchase: getData');
        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
die('Complete Purchase: sendData');
        return $this->response = new Response($this, $data);
    }
}

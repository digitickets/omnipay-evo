<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

use Guzzle\Common\Collection;
use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractThreeStepRedirectRequest extends AbstractRequest
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

    /**
     * Make a call to the Evo Three Step Redirect API endpoint, passing it the given (XML) data.
     * @param $data
     *
     * @return \Guzzle\Http\Message\Response
     */
    protected function apiRequest($data)
    {
        return $this
            ->httpClient
            ->post(
                $this->gatewayURL,
                new Collection(['content-type' => 'text/xml']),
                $data,
                ['timeout' => 5]
            )
            ->send();
    }
}
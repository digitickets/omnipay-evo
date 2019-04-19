<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractThreeStepRedirectResponse extends AbstractResponse
{
    /**
     * @var bool $successful
     */
    protected $successful = false;

    abstract protected function interpretResponse();

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $this->interpretResponse();
    }

    public function isSuccessful()
    {
        return $this->successful;
    }

    /**
     * @param \SimpleXMLElement $xmlObject
     * @param string $nodeName
     *
     * @return string|null
     */
    protected function getNode($xmlObject, $nodeName)
    {
        return isset($xmlObject->$nodeName) ? (string) $xmlObject->$nodeName : null;
    }
}
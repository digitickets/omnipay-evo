<?php

namespace Omnipay\Evo\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

/**
 * Evo Response
 */
class Response extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @var Omnipay\Evo\Message\PurchaseRequest $request The purchase request object.
     */
    protected $request;
    
    public function __construct(RequestInterface $request, $data)
    {
        // Decode the response (it's actually very simple).
        $this->data = $this->decode($data);
        $this->request = $request;
    }

    public function isSuccessful()
    {
        return (isset($this->data['status']) || $this->data['status'] === 'ok');
    }

    public function isRedirect()
    {
        // I think we *always* redirect.
        return true;
    }

    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return (string) $this->request->getRedirectUrl();
        }

        return '';
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        
        $redirectData = [
            'ClientId' => $this->request->getMerchantId(),
            'StoreType' => $this->request->getMerchantType(),
            'Token' => $this->data['msg'],
            'TranType' => 'Auth',
            'Total' => $this->request->getAmount(),
            'Currency' => $this->request->getCurrency(),
            'OrderId' => $this->request->getOrderId(),
            'ConsumerName' => 'FirstNameTBA',
            'ConsumerSurname' => 'SurnameTBA',
            'okUrl' => '/pay',
            'failUrl' => '/pay',
            'pendingURL' => '/pay',
            'lang' => 'en'
        ];
        return $redirectData;

    }
    
    protected function decode($data) {
        $tokenParts = [];
        parse_str($data, $tokenParts);
        return $tokenParts;
    }
}

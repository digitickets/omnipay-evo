<?php

namespace Omnipay\Evo\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

/**
 * Evo Response
 */
class CompleteResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @var Omnipay\Evo\Message\PurchaseRequest $request The purchase request object.
     */
    protected $request;

    public function __construct(RequestInterface $request, $data)
    {
        // Decode the response (it's actually very simple).
        $this->data = is_array($data) ? $data : [];
        $this->request = $request;
    }

    public function isSuccessful()
    {
        // For now, I just test whether the errMsg has anything in it, while I wait for a
        // definitive answer from BOIPA.
        return (isset($this->data['Response']) && $this->data['Response'] === 'Approved');
    }
    
    public function getMessage() {
        return ($this->isSuccessful() && isset($this->data['ErrMsg']) ? $this->data['ErrMsg'] : null);
    }
    
    public function getTransactionReference() {
        return ($this->isSuccessful() && isset($this->data['TransId']) ? $this->data['TransId'] : null);
    }

    public function getRedirectUrl() {
        return null;
    }
    
    public function getRedirectMethod() {
        return 'GET';
    }
    
    public function getRedirectData() {
        return [];
    }

}
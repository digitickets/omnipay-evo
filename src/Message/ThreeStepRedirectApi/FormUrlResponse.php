<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

use Omnipay\Common\Message\RequestInterface;

/**
 * Three Step Redirect Api Response
 */
class FormUrlResponse
{
    /**
     * @var PurchaseRequest $request The purchase request object.
     */
    protected $request;

    public function __construct(RequestInterface $request, $data)
    {
        // Decode the response (it's actually very simple).
\DigiTickets\Applications\Commands\Personal\Debug::log('Response data: '.var_export($data, true));
        $this->data = $this->decode($data);
        $this->request = $request;
    }

    public function isSuccessful()
    {
        // We actually want to always return false, so that the controller then checks
        // for redirection.
        // @TODO: This needs to change!
        return false;
    }

    public function getFormUrl()
    {
        return 'form-url:TBC';
    }
//
//    public function hasToken()
//    {
//        return (isset($this->data['status']) && $this->data['status'] === 'ok');
//    }

//    protected function decode($data) {
//        $tokenParts = [];
//        parse_str($data, $tokenParts);
//
//        return $tokenParts;
//    }
//
//    public function getMessage()
//    {
//        if ($this->hasToken()) {
//            return null;
//        }
//        if (isset($this->data['msg'])) {
//            return $this->data['msg'];
//        }
//
//        return 'Unable to retrieve error message';
//    }
}

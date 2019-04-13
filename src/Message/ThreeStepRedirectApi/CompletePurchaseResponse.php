<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

use Omnipay\Common\Message\RequestInterface;

/**
 * Three Step Redirect Api Response
 */
class CompletePurchaseResponse extends AbstractThreeStepRedirectResponse
{
    const RESULT__TRANSACTION_APPROVED = '1';
    /**
     * @var string|null
     */
    protected $code;

    /**
     * @var string|null
     */
    protected $message;

    /**
     * @var string|null
     */
    protected $transactionReference;

    /**
     * @var string|null
     */
    protected $authCode;

    /**
     * Take the raw data, convert to an XML object, then determine whether there was an error or not.
     * If not, extract the form-url.
     * We are not interested in why it failed.
     */
    protected function interpretResponse()
    {
        // Assume it wasn't successful.
        $this->successful = false;

        try {
            $responseXml = simplexml_load_string($this->data);

            // Extract the relevant parts of the response.
            $result = $this->getNode($responseXml, 'result');
            $this->code = $this->getNode($responseXml, 'result-code');
            $this->message = $this->getNode($responseXml, 'result-text');
            $this->transactionReference = $this->getNode($responseXml, 'transaction-id');
            $this->authCode = $this->getNode($responseXml, 'authorization-code');

            // If it was successful, set the appropriate values.
            if ($result === self::RESULT__TRANSACTION_APPROVED) {
                $this->successful = true;
            }
        } catch (\Exception $e) {
            // @TODO: Should we set the error message here that gets exposed by this class?
            // Do nothing - we've assumed it wasn't successful.
        }
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getTransactionReference()
    {
        return $this->transactionReference;
    }

    public function getAuthCode()
    {
        return $this->authCode;
    }
}

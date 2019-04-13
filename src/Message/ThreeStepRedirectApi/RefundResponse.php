<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

class RefundResponse extends AbstractThreeStepRedirectResponse
{
    const RESULT__REFUND_APPROVED = '1';

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
     * Take the raw data, convert to an XML object, then determine whether there was an error or not.
     * If not, extract the form-url.
     * We are not interested in why it failed.
     */
    protected function interpretResponse()
    {
\DigiTickets\Applications\Commands\Personal\Debug::log('Refund response: '.var_export($this->data, true));
        // Assume it wasn't successful.
        $this->successful = false;

        try {
            $responseXml = simplexml_load_string($this->data);

            // Extract the relevant parts of the response.
            $result = $this->getNode($responseXml, 'result');
            $this->code = $this->getNode($responseXml, 'result-code');
            $this->message = $this->getNode($responseXml, 'result-text');
            $this->transactionReference = $this->getNode($responseXml, 'transaction-id');

            // If it was successful, set the appropriate values.
            if ($result === self::RESULT__REFUND_APPROVED) {
                $this->successful = true;
            }
        } catch (\Exception $e) {
            // Set the error message here, based on the exception error.
            $this->message = 'Unexpected error: '.$e->getMessage();
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
}
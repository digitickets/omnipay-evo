<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

use Omnipay\Common\Message\RequestInterface;

/**
 * Three Step Redirect Api Response
 */
class FormUrlResponse extends AbstractThreeStepRedirectResponse
{
    const RESULT_CODE__TRANSACTION_WAS_APPROVED = '100';

    /**
     * @var string|null $formUrl
     */
    protected $formUrl;

    /**
     * Take the raw data, convert to an XML object, then determine whether there was an error or not.
     * If not, extract the form-url.
     * We are not interested in why it failed.
     */
    protected function interpretResponse()
    {
        // Assume it wasn't successful.
        $this->successful = false;
        $this->formUrl = null;

        try {
            $responseXml = simplexml_load_string($this->data);

            // Extract the relevant parts of the response.
            $resultCode = $this->getNode($responseXml, 'result-code');
            $formUrl = $this->getNode($responseXml, 'form-url');

            // If it was successful, set the appropriate values.
            if ($resultCode === self::RESULT_CODE__TRANSACTION_WAS_APPROVED && !is_null($formUrl)) {
                $this->successful = true;
                $this->formUrl = $formUrl;
            }
        } catch (\Exception $e) {
            // Do nothing - we've assumed it wasn't successful.
        }
    }

    public function getFormUrl()
    {
        return $this->formUrl;
    }
}

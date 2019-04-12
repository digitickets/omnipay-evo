<?php

namespace DigiTickets\Evo\Message\ThreeStepRedirectApi;

use SimpleXMLElement;
use Omnipay\Common\Message\AbstractRequest;

/**
 * Three Step Redirect Api Purchase Request
 */
class FormUrlRequest extends AbstractRequest
{
    protected $gatewayURL = 'https://secure.evogateway.com/api/v2/three-step';

    public function getData()
    {
\DigiTickets\Applications\Commands\Personal\Debug::log('getData in FormUrlRequest...');
        // Initiate Step One: Now that we've collected the non-sensitive payment information, we can combine other order information and build the XML format.
        $sales = new SimpleXMLElement('<sale></sale>');

        // Amount, authentication, and Redirect-URL are typically the bare minimum.
        $sales->addChild('api-key', /*'9hnkxu-8T8F6s-xsCJZW-85v26gM3YpXVua'*/ 'h22Emk93x3pB53ab99EPj95QWdBTAV3G' /*'2F822Rw39fx762MaV7Yy86jXGTC7sCDy'*/); // from params
        $sales->addChild('redirect-url', 'https://www.digitickets.co.uk'); // from params
        $sales->addChild('amount', '12.00'); // from params
        $sales->addChild('ip-address', '176.35.192.190' /*$_SERVER["REMOTE_ADDR"]*/); // from params
        $sales->addChild('currency', 'USD'); // from params

        // Some additonal fields may have been previously decided by user
        $sales->addChild('order-id', '1234'); // from params
        $sales->addChild('order-description', 'Small Order'); // from ??
        $sales->addChild('tax-amount' , '0.00');
        $sales->addChild('shipping-amount' , '0.00');

        // Fields added by me.
        $sales->addChild('industry', 'ecommerce');
        $sales->addChild('sec-code', 'WEB');
        $sales->addChild('order-date', '190412');

        $billing = $sales->addChild('billing');
        $billing->addChild('first-name', 'first-name'); // from params...
        $billing->addChild('last-name', 'last-name');
        $billing->addChild('address1', 'address1');
        $billing->addChild('city', 'city');
        $billing->addChild('state', 'state');
        $billing->addChild('postal', 'postal');
//        $billing->addChild(billing-address-email);
        $billing->addChild('country', 'country');
        $billing->addChild('email', 'email');
        $billing->addChild('phone', 'phone');
        $billing->addChild('company', 'company');
        $billing->addChild('address2', 'address2');
        $billing->addChild('fax', 'fax');

        $shipping = $sales->addChild('shipping');
        $shipping->addChild('first-name', 'first-name'); // from params...
        $shipping->addChild('last-name', 'last-name');
        $shipping->addChild('address1', 'address1');
        $shipping->addChild('city', 'city');
        $shipping->addChild('state', 'state');
        $shipping->addChild('postal', 'postal');
        $shipping->addChild('country', 'country');
        $shipping->addChild('phone', 'phone');
        $shipping->addChild('email', 'email');
        $shipping->addChild('company', 'company');
        $shipping->addChild('address2', 'address2');

        // Try adding a product...
        $product = $sales->addChild('product');
        $product->addChild('product-code', 'SKU-123456');
        $product->addChild('description', 'test product description');
        $product->addChild('commodity-code', 'abc');
        $product->addChild('unit-of-measure', 'lbs');
        $product->addChild('unit-cost', '5.00');
        $product->addChild('quantity', '1');
        $product->addChild('total-amount', '7.00');
        $product->addChild('tax-amount', '2.00');
        $product->addChild('tax-rate', '1.00');
        $product->addChild('discount-amount', '2.00');
        $product->addChild('discount-rate', '1.00');
        $product->addChild('tax-type', 'sales');
        $product->addChild('alternate-tax-id', '12345');

        return $sales->asXML();
    }

    /**
     * @param SimpleXMLElement $data
     * @return \Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
\DigiTickets\Applications\Commands\Personal\Debug::log('Sending data. We should have been given an XML document!');
\DigiTickets\Applications\Commands\Personal\Debug::log('Data to send is: '.var_export($data, true));
        // Send the data to the token URL and process the response.
        $formUrlResponse = $this->httpClient->post($this->gatewayURL, null, $data, ['timeout' => 5])->send();
\DigiTickets\Applications\Commands\Personal\Debug::log('Raw response: '.var_export((string) $formUrlResponse->getBody(), true));
        $this->response = new FormUrlResponse($this, (string) $formUrlResponse->getBody());
\DigiTickets\Applications\Commands\Personal\Debug::log('$this->response'.var_export($this->response, true));

        return $this->response;
    }
}

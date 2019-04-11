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
        $sales->addAttribute('api-key', /*'9hnkxu-8T8F6s-xsCJZW-85v26gM3YpXVua'*/ /*'h22Emk93x3pB53ab99EPj95QWdBTAV3G'*/ '2F822Rw39fx762MaV7Yy86jXGTC7sCDy'); // from params
        $sales->addAttribute('redirect-url', 'https://www.digitickets.co.uk'); // from params
        $sales->addAttribute('amount', '12.00'); // from params
        $sales->addAttribute('ip-address', '176.35.192.190' /*$_SERVER["REMOTE_ADDR"]*/); // from params
        $sales->addAttribute('currency', 'USD'); // from params

        // Some additonal fields may have been previously decided by user
        $sales->addAttribute('order-id', '1234'); // from params
        $sales->addAttribute('order-description', 'Small Order'); // from ??
        $sales->addAttribute('tax-amount' , '0.00');
        $sales->addAttribute('shipping-amount' , '0.00');

        $billing = $sales->addChild('billing');
        $billing->addAttribute('first-name', 'first-name'); // from params...
        $billing->addAttribute('last-name', 'last-name');
        $billing->addAttribute('address1', 'address1');
        $billing->addAttribute('city', 'city');
        $billing->addAttribute('state', 'state');
        $billing->addAttribute('postal', 'postal');
//        $billing->addAttribute(billing-address-email);
        $billing->addAttribute('country', 'country');
        $billing->addAttribute('email', 'email');
        $billing->addAttribute('phone', 'phone');
        $billing->addAttribute('company', 'company');
        $billing->addAttribute('address2', 'address2');
        $billing->addAttribute('fax', 'fax');

        $shipping = $sales->addChild('shipping');
        $shipping->addAttribute('first-name', 'first-name'); // from params...
        $shipping->addAttribute('last-name', 'last-name');
        $shipping->addAttribute('address1', 'address1');
        $shipping->addAttribute('city', 'city');
        $shipping->addAttribute('state', 'state');
        $shipping->addAttribute('postal', 'postal');
        $shipping->addAttribute('country', 'country');
        $shipping->addAttribute('phone', 'phone');
        $shipping->addAttribute('email', 'email');
        $shipping->addAttribute('company', 'company');
        $shipping->addAttribute('address2', 'address2');



//        $xmlRequest = new \DOMDocument('1.0','UTF-8');
//        $xmlRequest->formatOutput = true;
//
//        $xmlSale = $xmlRequest->createElement('sale');
//
//        // Amount, authentication, and Redirect-URL are typically the bare minimum.
//        appendXmlNode($xmlRequest, $xmlSale, 'api-key', '2F822Rw39fx762MaV7Yy86jXGTC7sCDy'); // from params
//        appendXmlNode($xmlRequest, $xmlSale, 'redirect-url', 'digitickets.co.uk'); // from params
//        appendXmlNode($xmlRequest, $xmlSale, 'amount', '12.00'); // from params
//        appendXmlNode($xmlRequest, $xmlSale, 'ip-address', $_SERVER["REMOTE_ADDR"]); // from params
//        appendXmlNode($xmlRequest, $xmlSale, 'currency', 'USD'); // from params
//
//        // Some additonal fields may have been previously decided by user
//        appendXmlNode($xmlRequest, $xmlSale, 'order-id', '1234'); // from params
//        appendXmlNode($xmlRequest, $xmlSale, 'order-description', 'Small Order'); // from ??
//        appendXmlNode($xmlRequest, $xmlSale, 'tax-amount' , '0.00');
//        appendXmlNode($xmlRequest, $xmlSale, 'shipping-amount' , '0.00');
//
//        /*if(!empty($_POST['customer-vault-id'])) {
//            appendXmlNode($xmlRequest, $xmlSale, 'customer-vault-id' , $_POST['customer-vault-id']);
//        }else {
//             $xmlAdd = $xmlRequest->createElement('add-customer');
//             appendXmlNode($xmlRequest, $xmlAdd, 'customer-vault-id' ,411);
//             $xmlSale->appendChild($xmlAdd);
//        }*/
//
//        // Set the Billing and Shipping from what was collected on initial shopping cart form
//        $xmlBillingAddress = $xmlRequest->createElement('billing');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'first-name', 'first-name'); // from params...
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'last-name', 'last-name');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'address1', 'address1');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'city', 'city');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'state', 'state');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'postal', 'postal');
//        //billing-address-email
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'country', 'country');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'email', 'email');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'phone', 'phone');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'company', 'company');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'address2', 'address2');
//        appendXmlNode($xmlRequest, $xmlBillingAddress, 'fax', 'fax');
//        $xmlSale->appendChild($xmlBillingAddress);
//
//        $xmlShippingAddress = $xmlRequest->createElement('shipping');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'first-name', 'first-name'); // from params...
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'last-name', 'last-name');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'address1', 'address1');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'city', 'city');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'state', 'state');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'postal', 'postal');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'country', 'country');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'phone', 'phone');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'email', 'email');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'company', 'company');
//        appendXmlNode($xmlRequest, $xmlShippingAddress, 'address2', 'address2');
//        $xmlSale->appendChild($xmlShippingAddress);

//        // Products already chosen by user
//        $xmlProduct = $xmlRequest->createElement('product');
//        appendXmlNode($xmlRequest, $xmlProduct,'product-code' , 'SKU-123456');
//        appendXmlNode($xmlRequest, $xmlProduct,'description' , 'test product description');
//        appendXmlNode($xmlRequest, $xmlProduct,'commodity-code' , 'abc');
//        appendXmlNode($xmlRequest, $xmlProduct,'unit-of-measure' , 'lbs');
//        appendXmlNode($xmlRequest, $xmlProduct,'unit-cost' , '5.00');
//        appendXmlNode($xmlRequest, $xmlProduct,'quantity' , '1');
//        appendXmlNode($xmlRequest, $xmlProduct,'total-amount' , '7.00');
//        appendXmlNode($xmlRequest, $xmlProduct,'tax-amount' , '2.00');
//
//        appendXmlNode($xmlRequest, $xmlProduct,'tax-rate' , '1.00');
//        appendXmlNode($xmlRequest, $xmlProduct,'discount-amount', '2.00');
//        appendXmlNode($xmlRequest, $xmlProduct,'discount-rate' , '1.00');
//        appendXmlNode($xmlRequest, $xmlProduct,'tax-type' , 'sales');
//        appendXmlNode($xmlRequest, $xmlProduct,'alternate-tax-id' , '12345');
//
//        $xmlSale->appendChild($xmlProduct);
//
//        $xmlProduct = $xmlRequest->createElement('product');
//        appendXmlNode($xmlRequest, $xmlProduct,'product-code' , 'SKU-123456');
//        appendXmlNode($xmlRequest, $xmlProduct,'description' , 'test 2 product description');
//        appendXmlNode($xmlRequest, $xmlProduct,'commodity-code' , 'abc');
//        appendXmlNode($xmlRequest, $xmlProduct,'unit-of-measure' , 'lbs');
//        appendXmlNode($xmlRequest, $xmlProduct,'unit-cost' , '2.50');
//        appendXmlNode($xmlRequest, $xmlProduct,'quantity' , '2');
//        appendXmlNode($xmlRequest, $xmlProduct,'total-amount' , '7.00');
//        appendXmlNode($xmlRequest, $xmlProduct,'tax-amount' , '2.00');
//
//        appendXmlNode($xmlRequest, $xmlProduct,'tax-rate' , '1.00');
//        appendXmlNode($xmlRequest, $xmlProduct,'discount-amount', '2.00');
//        appendXmlNode($xmlRequest, $xmlProduct,'discount-rate' , '1.00');
//        appendXmlNode($xmlRequest, $xmlProduct,'tax-type' , 'sales');
//        appendXmlNode($xmlRequest, $xmlProduct,'alternate-tax-id' , '12345');
//
//        $xmlSale->appendChild($xmlProduct);

//        $xmlRequest->appendChild($xmlSale);

        return $sales->asXML();

//        return [
//            'ClientId' => $this->getMerchantId(),
//            'Password' => $this->getPassword(),
//            'OrderId' => $this->getTransactionId(),
//            'Total' => $this->getAmount(),
//            'Currency' => $this->convertCurrency($this->getCurrency()),
//        ];
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

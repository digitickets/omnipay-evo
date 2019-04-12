<?php

namespace DigiTickets\Evo;

use Omnipay\Common\AbstractGateway;

/**
 * Class ThreeStepRedirectApiGateway
 * @package DigiTickets\Evo
 *
 * @link https://secure.evogateway.com/merchants/resources/integration/integration_portal.php?tid=0f90b6b6f2b53a1151c11477ce1bfa12#3step_methodology
 */
class ThreeStepRedirectApiGateway extends AbstractGateway
{
    public function formUrl(array $parameters = array())
    {
\DigiTickets\Applications\Commands\Personal\Debug::log('Purchase method being called...');
        return $this->createRequest('\DigiTickets\Evo\Message\ThreeStepRedirectApi\FormUrlRequest', $parameters);
    }

    public function getName()
    {
        return 'Evo Three Step Redirect Api';
    }
}
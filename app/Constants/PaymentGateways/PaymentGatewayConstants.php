<?php

namespace App\Constants\PaymentGateways;

/**
 * Class Constant.
 */
final class PaymentGatewayConstants
{
    public const CURRENCY = 'COP';
    public const IP_ADDRESS_PLACETOPAY =  '127.0.0.1';
    public const USER_AGENT_PLACETOPAY =  'PlacetoPay Sandbox';
    public const URL_PLACETOPAY = 'https://dev.placetopay.com/redirection/api/session';
    public const URL_REDIRECT_PLACETOPAY = 'https://checkout-co.placetopay.dev/session/';
    public const LOGIN_PLACETOPAY = '6dd490faf9cb87a9862245da41170ff2';

    public const URL_RETURN_PLACETOPAY = 'http://127.0.0.1:8000/orders/showOrder';
    public const DESCRIPTION_PLACETOPAY = 'Pago Merca todo Correspondiente a la orden No.';
    public const STATUS_ORDER_INPROCESSPAY = 'INPROCESSPAY';
}

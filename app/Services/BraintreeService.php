<?php

namespace App\Services;

class BraintreeService{

    private $apiGateway;

    public function construct(){
    }

    public function purchase($amount, $nonceFromTheClient, array $options = []){
        $apiGateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key')
        ]);

        $result = $apiGateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonceFromTheClient,
            'options' => $options
        ]);

        return $result;
    }
}
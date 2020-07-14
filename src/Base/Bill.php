<?php

namespace AimanDaniel\ToyyibPay\Base;

use AimanDaniel\ToyyibPay\Contracts\Bill as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Contracts\Response;

abstract class Bill extends Request implements Contract
{
    public function create(
        string $categoryCode,
        string $billName,
        string $billDescription,
        int $billPriceSetting,
        int $billPayerInfo,
        string $billAmount, // WIP: use money library
        string $billReturnUrl,
        string $billCallbackUrl,
        string $billExternalReferenceNo,
        string $billTo, // nullable
        string $billEmail,
        string $billPhone,
        int $billSplitPayment = 0, // wip: add constant
        string $billSplitPaymentArgs, // handle json
        string $billPaymentChannel, //Set 0 for FPX, 1 Credit Card and 2 for both FPX & Credit Card.
        int $billDisplayMerchant = 1,
        string $billContentEmail = '',
        string $billChargeToCustomer //wip: add constants
    ): Response {
        return $this->send('POST', 'createBill', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'categoryCode' => $categoryCode,
            'billName' => $billName,
            'billDescription' => $billDescription,
            'billPriceSetting' => $billPriceSetting,
            'billPayorInfo' => $billPayerInfo,
            'billAmount' => $billAmount,
            'billReturnUrl' => $billReturnUrl,
            'billCallbackUrl' => $billCallbackUrl,
            'billExternalReferenceNo' => $billExternalReferenceNo,
            'billTo' => $billTo,
            'billEmail' => $billEmail,
            'billPhone' => $billPhone,
            'billSplitPayment' => $billSplitPayment,
            'billSplitPaymentArgs' => $billSplitPaymentArgs,
            'billPaymentChannel' => $billPaymentChannel,
            'billDisplayMerchant' => $billDisplayMerchant,
            'billContentEmail' => $billContentEmail,
            'billChargeToCustomer' => $billChargeToCustomer,
        ]);
    }

    public function createMultiPayment(
        string $categoryCode,
        string $billName,
        string $billDescription,
        string $billPriceSetting,
        string $billPayerInfo,
        string $billAmount,
        string $billReturnUrl,
        string $billCallbackUrl,
        string $billExternalReferenceNo,
        string $billTo,
        string $billEmail,
        string $billPhone,
        string $billSplitPayment,
        string $billSplitPaymentArgs,
        string $billMultiPayment,
        string $billPaymentChannel,
        string $billDisplayMerchant,
        string $billContentEmail
    ): Response { // WIP: refactor. array_merge, compact etc
        return $this->send('POST', 'createBillMultiPayment', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'categoryCode' => $categoryCode,
            'billName' => $billName,
            'billDescription' => $billDescription,
            'billPriceSetting' => $billPriceSetting,
            'billPayorInfo' => $billPayerInfo,
            'billAmount' => $billAmount,
            'billReturnUrl' => $billReturnUrl,
            'billCallbackUrl' => $billCallbackUrl,
            'billExternalReferenceNo' => $billExternalReferenceNo,
            'billTo' => $billTo,
            'billEmail' => $billEmail,
            'billPhone' => $billPhone,
            'billSplitPayment' => $billSplitPayment,
            'billSplitPaymentArgs' => $billSplitPaymentArgs,
            'billMultiPayment' => $billMultiPayment,
            'billPaymentChannel' => $billPaymentChannel,
            'billDisplayMerchant' => $billDisplayMerchant,
            'billContentEmail' => $billContentEmail
        ]);
    }

    public function run(
        string $billCode,
        string $billpaymentAmount, // WIP: use money library, amount in cent
        string $billpaymentPayerName,
        string $billpaymentPayerPhone,
        string $billpaymentPayerEmail,
        string $billBankID
    ): Response {
        return $this->send('POST', 'runBill', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'billCode' => $billCode,
            'billpaymentAmount' => $billpaymentAmount,
            'billpaymentPayorName' => $billpaymentPayerName,
            'billpaymentPayorPhone' => $billpaymentPayerPhone,
            'billpaymentPayorEmail' => $billpaymentPayerEmail,
            'billBankID' => $billBankID
        ]);
    }

    // WIP: handle billpaymentStatus
    public function transactions(string $billCode, ?int $billpaymentStatus = 1): Response
    {
        return $this->client->uses('Bill.Transaction')->all($billCode, $billpaymentStatus);
    }

    // WIP: handle partnertype OEM|ENTERPRISE
    public function all(string $partnerType, ?string $yearMonth = null): Response
    {
        $this->client->useCustomApiEndpoint(
            !$this->client->isUsingSandbox()
            ? 'https://toyyibpay.com/admin/api'
            : 'https://dev.toyyibpay.com/admin/api'
        );

        $body = [
            'userSecretKey' => $this->client->getApiKey(),
            'partnerType' => $partnerType,
        ];

        if (!is_null($yearMonth)) {
            $body['yearMonth'] = $yearMonth;
        }

        return $this->send('POST', 'getAllBill', [], $body);
    }
}

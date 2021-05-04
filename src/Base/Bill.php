<?php

namespace AimanDaniel\ToyyibPay\Base;

use AimanDaniel\ToyyibPay\Contracts\Bill as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Concerns\Request\Multipart;
use Laravie\Codex\Contracts\Response as ResponseContract;

abstract class Bill extends Request implements Contract
{
    use Multipart;

    public function create(
        string $billName,
        string $billDescription,
        int $billPriceSetting,
        int $billPayerInfo,
        string $billAmount, // WIP: use money library
        string $billReturnUrl,
        string $billCallbackUrl,
        string $billExternalReferenceNo,
        ?string $billTo, // nullable
        string $billEmail,
        string $billPhone,
        array $optional = []
    ): ResponseContract {
        $extras = [
            'billSplitPayment' => (isset($optional['billSplitPayment']) && $optional['billSplitPayment'] == Bill::PAYMENT_SPLIT)
                ? Bill::PAYMENT_SPLIT
                : '',

            // WIP" handle json
            'billSplitPaymentArgs' => $optional['billSplitPaymentArgs'] ?? '',

            //Set 0 for FPX, 1 Credit Card and 2 for both FPX & Credit Card.
            'billPaymentChannel' => $optional['billPaymentChannel'] ?? Bill::PAYMENT_CHANNEL_BOTH,

            //1,
            'billDisplayMerchant' => $optional['billDisplayMerchant'] ?? Bill::MERCHANT_DISPLAY,

            'billContentEmail' => $optional['billContentEmail'] ?? '',

            //wip: add/use constants
            'billChargeToCustomer' => $optional['billChargeToCustomer'] ?? Bill::CHARGE_OWNER_BOTH,
        ];

        $data = array_merge([
            'userSecretKey' => $this->client->getApiKey(),
            'categoryCode' => $this->client->getCategoryCode(),
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
            'billPhone' => $billPhone
        ], $extras);

        return $this->stream('POST', 'createBill', [], $data);
    }

    public function createMultiPayment(
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
    ): ResponseContract { // WIP: refactor. array_merge, compact etc
        return $this->stream('POST', 'createBillMultiPayment', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'categoryCode' => $this->client->getCategoryCode(),
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
    ): ResponseContract {
        return $this->stream('POST', 'runBill', [], [
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
    public function transactions(string $billCode, ?int $billpaymentStatus = 1): ResponseContract
    {
        return $this->client->uses('Bill.Transaction')->all($billCode, $billpaymentStatus);
    }

    // WIP: handle partnertype OEM|ENTERPRISE
    public function all(string $partnerType, ?string $yearMonth = null): ResponseContract
    {
        $this->client->useAdminApiEndpoint();

        $body = [
            'userSecretKey' => $this->client->getApiKey(),
            'partnerType' => $partnerType,
        ];

        if (!is_null($yearMonth)) {
            $body['yearMonth'] = $yearMonth;
        }

        return $this->stream('POST', 'getAllBill', [], $body);
    }
}

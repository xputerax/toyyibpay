<?php

namespace AimanDaniel\ToyyibPay\Contracts;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface Bill extends Request
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
        string $billChargeToCustomer //wip: add/use constants
    ): Response;

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
    ): Response;

    public function run(
        string $billCode,
        string $billpaymentAmount, // WIP: use money library
        string $billpaymentPayerName,
        string $billpaymentPayerPhone,
        string $billpaymentPayerEmail,
        string $billBankID
    ): Response;

    public function transactions(string $billCode, ?int $billpaymentStatus = 1): Response;

    public function all(string $partnerType, ?string $yearMonth): Response;
}

<?php

namespace AimanDaniel\ToyyibPay\Contracts;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface Bill extends Request
{
    const PRICE_DYNAMIC = 0;
    const PRICE_FIXED = 1;

    const PAYER_NONE = 0;
    const PAYER_REQUIRED = 1;

    const PAYMENT_SPLIT = 1;

    const PAYMENT_CHANNEL_FPX = 0;
    const PAYMENT_CHANNEL_CC = 1;
    const PAYMENT_CHANNEL_BOTH = 2;

    const MERCHANT_HIDE = 0;
    const MERCHANT_DISPLAY = 1;

    const CHARGE_OWNER_BOTH = null;
    const CHARGE_FPX_CUSTOMER_CC_OWNER = 0;
    const CHARGE_FPX_OWNER_CC_CUSTOMER = 1;
    const CHARGE_CUSTOMER_BOTH = 2;

    public function create(
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
        array $optionals = []
    ): Response;

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

    public function all(string $partnerType, ?string $yearMonth = null): Response;
}

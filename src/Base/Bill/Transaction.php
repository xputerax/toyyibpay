<?php

namespace AimanDaniel\ToyyibPay\Base\Bill;

use AimanDaniel\ToyyibPay\Contracts\Bill\Transaction as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Contracts\Response;
use Laravie\Codex\Concerns\Request\Multipart;

abstract class Transaction extends Request implements Contract
{
    use Multipart;

    public function all(string $billCode, ?int $billPaymentStatus): Response
    {
        $body = [ 'billCode' => trim($billCode) ];

        // WIP: handle accepted values
        if (!\is_null($billPaymentStatus)) {
            $body['billpaymentStatus'] = $billPaymentStatus;
        }

        return $this->stream('POST', 'getBillTransactions', [], $body);
    }
}

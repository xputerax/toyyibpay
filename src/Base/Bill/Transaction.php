<?php

namespace AimanDaniel\ToyyibPay\Base\Bill;

use AimanDaniel\ToyyibPay\Contracts\Bill\Transaction as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Contracts\Response;

abstract class Transaction extends Request implements Contract
{
    public function all(string $billCode, ?int $billPaymentStatus): Response
    {
        $body = [ 'billCode' => $billPaymentStatus ];

        // WIP: handle accepted values
        if (!\is_null($billPaymentStatus)) {
            $body['billpaymentStatus'] = $billPaymentStatus;
        }

        return $this->send('POST', 'getBillTransactions', [], $body);
    }

    /* macam tak perlu je
    // WIP: put constant in another file
    public function successful(string $billCode): Response
    {
        return $this->all($billCode, 1);
    }

    public function pending(string $billCode): Response
    {
        return $this->all($billCode, 2);
    }

    public function unsuccessful(string $billCode): Response
    {
        return $this->all($billCode, 3);
    }*/
}

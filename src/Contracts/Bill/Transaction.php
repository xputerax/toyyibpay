<?php

namespace AimanDaniel\ToyyibPay\Contracts\Bill;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface Transaction extends Request
{
    const STATUS_SUCCESS = 1;
    const STATUS_PENDING = 2;
    const STATUS_FAILED = 3;

    public function all(string $billCode, ?int $billPaymentStatus): Response;
}

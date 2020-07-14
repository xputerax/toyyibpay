<?php

namespace AimanDaniel\ToyyibPay\Contracts\Bill;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface Transaction extends Request
{
    public function all(string $billCode, ?int $billPaymentStatus): Response;
}

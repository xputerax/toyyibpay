<?php

namespace AimanDaniel\ToyyibPay\Contracts;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface Settlement extends Request
{
    public function all(string $partnerType, bool $groupByUsername): Response;

    public function summary(string $partnerType, string $username): Response;
}

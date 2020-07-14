<?php

namespace AimanDaniel\ToyyibPay\Contracts;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface Settlement extends Request
{
    const GROUP_BY_USERNAME = 'Yes';
    const DONT_GROUP_BY_USERNAME = 'No';

    public function all(string $partnerType, bool $groupByUsername): Response;

    public function summary(string $partnerType, string $username): Response;
}

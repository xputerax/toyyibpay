<?php

namespace AimanDaniel\ToyyibPay\Contracts\User;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface Status extends Request
{
    public function get(string $username): Response;
}

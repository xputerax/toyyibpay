<?php

namespace AimanDaniel\ToyyibPay\Contracts;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface Bank extends Request
{
    public function all(): Response;

    public function fpx(): Response;
}

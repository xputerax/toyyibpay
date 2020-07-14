<?php

namespace AimanDaniel\ToyyibPay\Contracts;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface Category extends Request
{
    public function create(string $name, string $description): Response;

    public function get(string $categoryCode): Response;
}

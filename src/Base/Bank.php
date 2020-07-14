<?php

namespace AimanDaniel\ToyyibPay\Base;

use AimanDaniel\ToyyibPay\Contracts\Bank as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Contracts\Response;

abstract class Bank extends Request implements Contract
{
    public function all(): Response
    {
        return $this->send('GET', 'getBank');
    }

    public function fpx(): Response
    {
        return $this->send('GET', 'getBankFPX');
    }
}
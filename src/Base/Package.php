<?php

namespace AimanDaniel\ToyyibPay\Base;

use AimanDaniel\ToyyibPay\Contracts\Package as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Contracts\Response;

abstract class Package extends Request implements Contract
{
    public function all(): Response
    {
        return $this->send('GET', 'getPackage');
    }
}

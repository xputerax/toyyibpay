<?php

namespace AimanDaniel\ToyyibPay\One;

use AimanDaniel\ToyyibPay\Base\Bill\Transaction as BaseRequest;

class Transaction extends BaseRequest
{
    /**
     * Version namespace.
     *
     * @var string
     */
    protected $version = 'v1';
}

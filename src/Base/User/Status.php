<?php

namespace AimanDaniel\ToyyibPay\Base\User;

use AimanDaniel\ToyyibPay\Contracts\User\Status as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Concerns\Request\Multipart;
use Laravie\Codex\Contracts\Response;

abstract class Status extends Request implements Contract
{
    use Multipart;

    public function get(string $username): Response
    {
        return $this->stream('POST', 'getUserStatus', [], [
            'enterpriseUserSecretKey' => $this->client->getApiKey(),
            'username' => $username,
        ]);
    }
}

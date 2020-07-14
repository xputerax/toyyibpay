<?php

namespace AimanDaniel\ToyyibPay\Base;

use AimanDaniel\ToyyibPay\Contracts\Settlement as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Concerns\Request\Multipart;
use Laravie\Codex\Contracts\Response;

abstract class Settlement extends Request implements Contract
{
    use Multipart;

    public function all(string $partnerType, bool $groupByUsername): Response
    {
        $this->client->useAdminApiEndpoint();

        return $this->stream('POST', 'getSettlement', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'partnerType' => $partnerType,
            'detailByuserName' => $groupByUsername
        ]);
    }

    public function summary(string $partnerType, string $username): Response
    {
        $this->client->useAdminApiEndpoint();

        return $this->stream('POST', 'getSettlementSummary', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'userPartnerType' => $partnerType,
            'userName' => $username,
        ]);
    }
}

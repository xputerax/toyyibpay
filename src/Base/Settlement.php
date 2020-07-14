<?php

namespace AimanDaniel\ToyyibPay\Base;

use AimanDaniel\ToyyibPay\Contracts\Settlement as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Contracts\Response;

abstract class Settlement extends Request implements Contract
{
    public function all(string $partnerType, bool $groupByUsername): Response
    {
        $this->client->useAdminApiEndpoint();

        return $this->send('POST', 'getSettlement', [], [
            'partnerType' => $partnerType,
            'detailByuserName' => $groupByUsername
        ]);
    }

    public function summary(string $partnerType, string $username): Response
    {
        $this->client->useAdminApiEndpoint();

        return $this->send('POST', 'getSettlementSummary', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'userPartnerType' => $partnerType,
            'userName' => $username,
        ]);
    }
}

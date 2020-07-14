<?php

namespace AimanDaniel\ToyyibPay\Base;

use AimanDaniel\ToyyibPay\Contracts\Category as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Contracts\Response;

abstract class Category extends Request implements Contract
{
    public function create(string $name, string $description): Response
    {
        return $this->send('POST', 'createCategory', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'catname' => $name,
            'catdescription' => $description,
        ]);
    }

    public function get(string $categoryCode): Response
    {
        return $this->send('POST', 'getCategoryDetails', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'categoryCode' => $categoryCode,
        ]);
    }
}

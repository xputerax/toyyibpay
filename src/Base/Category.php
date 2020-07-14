<?php

namespace AimanDaniel\ToyyibPay\Base;

use AimanDaniel\ToyyibPay\Contracts\Category as Contract;
use AimanDaniel\ToyyibPay\Request;
use Laravie\Codex\Concerns\Request\Multipart;
use Laravie\Codex\Contracts\Response;

abstract class Category extends Request implements Contract
{
    use Multipart;

    public function create(string $name, string $description): Response
    {
        return $this->stream('POST', 'createCategory', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'catname' => $name,
            'catdescription' => $description,
        ]);
    }

    public function get(string $categoryCode): Response
    {
        return $this->stream('POST', 'getCategoryDetails', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'categoryCode' => $categoryCode,
        ]);
    }
}

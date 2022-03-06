<?php

use AimanDaniel\ToyyibPay\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private $apiKey;
    private $categoryCode;

    public function setUp(): void
    {
        global $apiKey, $categoryCode;

        $this->apiKey = $apiKey;
        $this->categoryCode = $categoryCode;
    }

    public function testClientExisted()
    {
        global $apiKey, $categoryCode;

        $client = Client::make($apiKey, $categoryCode);

        $this->assertSame($apiKey, $client->getApiKey());
        $this->assertInstanceOf(Client::class, $client);
    }
}

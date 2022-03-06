<?php

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use AimanDaniel\ToyyibPay\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;

class CategoryTest extends TestCase
{
    private $apiKey;
    private $categoryCode;
    private $sandbox;

    public function setUp(): void
    {
        global $apiKey, $categoryCode, $sandbox;

        $this->apiKey = $apiKey;
        $this->categoryCode = $categoryCode;
        $this->sandbox = $sandbox;
    }

    public function testShouldReturnCategory()
    {
        $client = Client::make($this->apiKey, $this->categoryCode);

        if ($this->sandbox) {
            $client->useSandbox();
        }
        
        $mock = new MockHandler([
            new Response(status: 200, body: 'Berjaya Cringe'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $req = new HttpClient(['handler' => $handlerStack]);

        $response = $req->request('POST', 'https://toyyibpay.com/index.php/api/getCategoryDetails');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertInstanceOf(Client::class, $client);
    }
}

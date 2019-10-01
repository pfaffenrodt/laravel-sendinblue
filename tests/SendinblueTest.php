<?php

namespace Damcclean\Sendinblue\Tests;

use Damcclean\Sendinblue\Sendinblue;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\TestCase;
use SendinBlue\Client\Model\GetAccount;

class SendinblueTest extends TestCase
{
    private function getSendinblue($status, $body)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return new Sendinblue($client);
    }

    public function testGetAccounts()
    {
        Config::shouldReceive('get')
            ->once()
            ->andReturn('api-key');

        $response = $this->getSendinblue(200, json_encode([]))->getAccount();
        $this->assertInstanceOf(GetAccount::class, $response);
    }
}

<?php
namespace Damcclean\Sendinblue\Tests;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [\Damcclean\Sendinblue\SendinblueServiceProvider::class];
    }

    protected function mockHttpResponse($status, $body)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        app()->instance('sendinblue.client', $client);
    }

    protected function configProvideApiKey()
    {
        Config::set('sendinblue.apiKey', 'api-key');
    }
}

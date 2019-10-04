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
use SendinBlue\Client\Model\GetAttributes;
use SendinBlue\Client\Model\GetContacts;
use SendinBlue\Client\Model\GetFolders;
use SendinBlue\Client\Model\GetLists;

class SendinblueTest extends TestCase
{
    private function getSendinblue($status, $body)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return new Sendinblue($client);
    }

    /** @test */
    public function can_get_account()
    {
        Config::shouldReceive('get')
            ->once()
            ->andReturn('api-key');

        $response = $this->getSendinblue(200, json_encode([]))->getAccount();
        $this->assertInstanceOf(GetAccount::class, $response);
    }

    /** @test */
    public function can_get_contacts()
    {
        Config::shouldReceive('get')
            ->once()
            ->andReturn('api-key');

        $response = $this->getSendinblue(200, json_encode([]))->getContacts();

        $this->assertInstanceOf(GetContacts::class, $response);
    }

    /** @test */
    public function can_get_contacts_from_list()
    {
        //
    }

    /** @test */
    public function can_get_contact_details()
    {
        //
    }

    /** @test */
    public function can_create_contact()
    {
        //
    }

    /** @test */
    public function can_get_contact_stats()
    {
        //
    }

    /** @test */
    public function can_update_contact()
    {
        //
    }

    /** @test */
    public function can_add_contact_to_list()
    {
        //
    }

    /** @test */
    public function can_remove_contact_from_list()
    {
        //
    }

    /** @test */
    public function can_delete_contact()
    {
        //
    }

    /** @test */
    public function can_get_folders()
    {
        Config::shouldReceive('get')
            ->once()
            ->andReturn('api-key');

        $response = $this->getSendinblue(200, json_encode([]))->getFolders(10, 0);

        $this->assertInstanceOf(GetFolders::class, $response);
    }

    /** @test */
    public function can_get_folder()
    {
        //
    }

    /** @test */
    public function can_get_folder_lists()
    {
        //
    }

    /** @test */
    public function can_create_folder()
    {
        //
    }

    /** @test */
    public function can_delete_folder()
    {
        //
    }

    /** @test */
    public function can_get_lists()
    {
        Config::shouldReceive('get')
            ->once()
            ->andReturn('api-key');

        $response = $this->getSendinblue(200, json_encode([]))->getLists();

        $this->assertInstanceOf(GetLists::class, $response);
    }

    /** @test */
    public function can_get_list()
    {
        //
    }

    /** @test */
    public function can_create_list()
    {
        //
    }

    /** @test */
    public function can_delete_list()
    {
        //
    }

    /** @test */
    public function can_get_attributes()
    {
        Config::shouldReceive('get')
            ->once()
            ->andReturn('api-key');

        $response = $this->getSendinblue(200, json_encode([]))->getAttributes();

        $this->assertInstanceOf(GetAttributes::class, $response);
    }

    /** @test */
    public function can_create_attribute()
    {
        //
    }

    /** @test */
    public function can_delete_attribute()
    {
        //
    }
}

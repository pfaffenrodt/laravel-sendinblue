<?php

namespace Damcclean\Sendinblue\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\CreateUpdateContactModel;
use SendinBlue\Client\Model\GetAccount;
use SendinBlue\Client\Model\GetAttributes;
use SendinBlue\Client\Model\GetContacts;
use SendinBlue\Client\Model\GetFolders;
use SendinBlue\Client\Model\GetLists;

class SendinblueTest extends TestCase
{
    /**
     * @return \Damcclean\Sendinblue\Sendinblue
     */
    private function getSendinblue()
    {
        $instance = app('sendinblue');

        $this->assertInstanceOf(\Damcclean\Sendinblue\Sendinblue::class, $instance);

        return $instance;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->configProvideApiKey();
        $this->mockHttpResponse(200, json_encode([]));
    }

    /** @test */
    public function it_provide_api_key_from_config()
    {
        Config::shouldReceive('get')
            ->once()
            ->andReturn('api-key');
        $configuration = app('sendinblue.config');

        $this->assertInstanceOf(Configuration::class, $configuration);
        $this->assertEquals('api-key', $configuration->getApiKey('api-key'));
    }

    /** @test */
    public function can_get_account()
    {
        $response = $this->getSendinblue()->getAccount();

        $this->assertInstanceOf(GetAccount::class, $response);
    }

    /** @test */
    public function can_get_contacts()
    {
        $response = $this->getSendinblue()->getContacts();

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

    public function createContactScenarios()
    {
        $email = 'sendinblue@example.com';
        $attributes = ['attribute1', 'attribute2', 'attribute3'];
        $listIds = ['id', 'id2'];
        $contactData = collect([
            'email'      => $email,
            'attributes' => $attributes,
            'listIds'    => $listIds,
        ]);

        return [
            'create_contact_with_email'      => [$contactData->only('email')],
            'create_contact_with_attributes' => [$contactData->only('email', 'attributes')],
            'create_contact_with_listIds'    => [$contactData->only('email', 'listIds')],
            'create_contact_with_all_values' => [$contactData->only('email', 'attributes', 'listIds')],
        ];
    }

    /**
     * @dataProvider createContactScenarios
     * @test
     */
    public function can_create_contact(Collection $contactData)
    {
        $expectedContact = new CreateUpdateContactModel(['id' => 'test']);
        $mockApi = $this->mock(ContactsApi::class);
        app()->instance(ContactsApi::class, $mockApi);

        $mockApi
            ->shouldReceive('createContact')
            ->with($contactData->toJson())
            ->andReturn($expectedContact);

        $newContact = $this->getSendinblue()
            ->createContact(
                $contactData->get('email'),
                $contactData->get('attributes'),
                $contactData->get('listIds')
            );

        $this->assertEquals($expectedContact, $newContact);
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
        $response = $this->getSendinblue()->getFolders(10, 0);

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
        $response = $this->getSendinblue()->getLists();

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
        $response = $this->getSendinblue()->getAttributes();

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

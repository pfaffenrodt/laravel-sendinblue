<?php

namespace Damcclean\Sendinblue;

use GuzzleHttp\Client;
use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Api\AttributesApi;
use SendinBlue\Client\Configuration;

class Sendinblue
{
    public function __construct()
    {
        $this->config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('sendinblue.apiKey'));
        $this->client = new Client();

        $this->accounts = new AccountApi($this->client, $this->config);
        $this->contacts = new ContactsApi($this->client, $this->config);
        $this->attributes = new AttributesApi($this->client, $this->config);
    }

    public function getAccount()
    {
        return $this->accounts->getAccount();
    }

    public function getContacts()
    {
        return $this->contacts->getContacts();
    }

    public function getContactDetails($email)
    {
        return $this->contacts->getContactInfo($email);
    }

    public function createContact($email, $attributes = null, $listIds = null)
    {
        $options = [
            'email' => $email
        ];

        if($attributes != null) {
            $options['attributes'] = $attributes;
        }

        if($listIds != null) {
            $options['listIds'] = $listIds;
        }

        return $this->contacts->createContact(json_encode($options));
    }

    public function addContactToList($listId, $email)
    {
        $options = [
            'listId' => $listId,
            'email' => $email
        ];

        return $this->contacts->addContactToList(json_encode($options));
    }

    public function deleteContact($email)
    {
        return $this->contacts->deleteContact($email);
    }
    
    public function createFolder($name) 
    {
        $options = [
            'name' => $name
        ];

        return $this->contacts->createFolder(json_encode($options));
    }

    public function getLists()
    {
        return $this->contacts->getLists();
    }

    public function getList($listId)
    {
        return $this->contacts->getList($listId);
    }

    public function createList($name, $folderId)
    {
        $options = [
            'name' => $name,
            'folderId' => $folderId
        ];

        return $this->contacts->createList(json_encode($options));
    }

    public function getAttributes()
    {
        return $this->attributes->getAttributes();
    }

    public function createAttribute($name, $category = null, $attribute = null)
    {
        return $this->attributes->createAttribute($category, $name, $attribute);
    }

    public function deleteAttribute($category = null, $name)
    {
        return $this->attributes->deleteAttribute($category, $name);
    }
}

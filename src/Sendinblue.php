<?php

namespace Damcclean\Sendinblue;

use GuzzleHttp\Client;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Api\AttributesApi;

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

    /*
        Account
    */

    public function getAccount()
    {
        return $this->accounts->getAccount();
    }

    /*
        Contacts
    */

    public function getContacts()
    {
        return $this->contacts->getContacts();
    }

    public function getContactsFromList($listId)
    {
        return $this->contacts->getContactsFromList($listId);
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

    public function getContactStats($id)
    {
        return $this->contacts->getContactStats($id);
    }

    public function updateContact($email, $properties)
    {
        $options = [];

        if(array_key_exists('attributes', $properties)) {
            $options['attributes'] = $properties['attributes'];
        }
        
        if(array_key_exists('emailBlacklisted', $properties)) {
            $options['emailBlacklisted'] = $properties['emailBlacklisted'];
        }

        if(array_key_exists('smsBlacklisted', $properties)) {
            $options['smsBlacklisted'] = $properties['smsBlacklisted'];
        }

        if(array_key_exists('listIds', $properties)) {
            $options['listIds'] = $properties['listIds'];
        }

        if(array_key_exists('unlinkListIds', $properties)) {
            $options['unlinkListIds'] = $properties['unlinkListIds'];
        }

        if(array_key_exists('smtpBlacklistSender', $properties)) {
            $options['smtpBlacklistSender'] = $properties['smtpBlacklistSender'];
        }

        return $this->contacts->updateContact($email, $options);
    }

    public function addContactToList($listId, $email)
    {
        $options = [
            'listId' => $listId,
            'email' => $email
        ];

        return $this->contacts->addContactToList(json_encode($options));
    }

    public function removeContactFromList($listId, $email)
    {
        return $this->contacts->removeContactFromList($listId, $email);
    }

    public function deleteContact($email)
    {
        return $this->contacts->deleteContact($email);
    }

    /*
        Folders
    */

    public function getFolders()
    {
        return $this->contacts->getFolders();
    }

    public function getFolder($id)
    {
        return $this->contacts->getFolder($id);
    }

    public function getFolderLists($id)
    {
        return $this->contacts->getFolderLists($id);
    }
    
    public function createFolder($name) 
    {
        $options = [
            'name' => $name
        ];

        return $this->contacts->createFolder(json_encode($options));
    }

    public function deleteFolder($id)
    {
        return $this->contacts->deleteFolder($id);
    }

    /*
        Lists
    */

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

    public function deleteList($id)
    {
        return $this->contacts->deleteList($id);
    }

    /*
        Attributes
    */

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

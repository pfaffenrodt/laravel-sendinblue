<?php

namespace Damcclean\Sendinblue;

use GuzzleHttp\Client;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Api\AttributesApi;
use Illuminate\Support\Facades\Config;

class Sendinblue
{
    /** @var Client */
    private $client;

    /** @var Configuration */
    private $config = null;

    /** @var AccountApi */
    private $accountApi = null;

    /** @var ContactsApi */
    private $contactsApi = null;

    /** @var AttributesApi */
    private $attributesApi = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Configuration
     */
    private function getConfiguration()
    {
        if (null === $this->config) {
            $this->config = Configuration::getDefaultConfiguration()->setApiKey('api-key', Config::get('sendinblue.apiKey'));
        }

        return $this->config;
    }

    /**
     * @return AccountApi
     */
    private function getAccountApi()
    {
        if (null === $this->accountApi) {
            $this->accountApi = new AccountApi($this->client, $this->getConfiguration());
        }

        return $this->accountApi;
    }

    /**
     * @return ContactsApi
     */
    private function getContactsApi()
    {
        if (null === $this->contactsApi) {
            $this->contactsApi = new ContactsApi($this->client, $this->getConfiguration());
        }

        return $this->contactsApi;
    }

    /**
     * @return AttributesApi
     */
    private function getAttributesApi()
    {
        if (null === $this->attributesApi) {
            $this->attributesApi = new AttributesApi($this->client, $this->getConfiguration());
        }

        return $this->attributesApi;
    }

    /**
     * @return \SendinBlue\Client\Model\GetAccount
     * @throws \SendinBlue\Client\ApiException
     */
    public function getAccount()
    {
        return $this->getAccountApi()->getAccount();
    }

    /**
     * @return \SendinBlue\Client\Model\GetContacts
     * @throws \SendinBlue\Client\ApiException
     */
    public function getContacts()
    {
        return $this->getContactsApi()->getContacts();
    }

    /**
     * @param $listId
     * @return \SendinBlue\Client\Model\GetContacts
     * @throws \SendinBlue\Client\ApiException
     */
    public function getContactsFromList($listId)
    {
        return $this->getContactsApi()->getContactsFromList($listId);
    }

    /**
     * @param $email
     * @return \SendinBlue\Client\Model\GetExtendedContactDetails
     * @throws \SendinBlue\Client\ApiException
     */
    public function getContactDetails($email)
    {
        return $this->getContactsApi()->getContactInfo($email);
    }

    /**
     * @param $email
     * @param null $attributes
     * @param null $listIds
     * @return \SendinBlue\Client\Model\CreateUpdateContactModel
     * @throws \SendinBlue\Client\ApiException
     */
    public function createContact($email, $attributes = null, $listIds = null)
    {
        $options = [
            'email' => $email
        ];

        if ($attributes != null) {
            $options['attributes'] = $attributes;
        }

        if ($listIds != null) {
            $options['listIds'] = $listIds;
        }

        return $this->getContactsApi()->createContact(json_encode($options));
    }

    /**
     * @param $email
     * @return \SendinBlue\Client\Model\GetContactCampaignStats
     * @throws \SendinBlue\Client\ApiException
     */
    public function getContactStats($email)
    {
        return $this->getContactsApi()->getContactStats($email);
    }

    /**
     * @param $email
     * @param $properties
     * @throws \SendinBlue\Client\ApiException
     */
    public function updateContact($email, $properties)
    {
        $options = [];

        if (array_key_exists('attributes', $properties)) {
            $options['attributes'] = $properties['attributes'];
        }

        if (array_key_exists('emailBlacklisted', $properties)) {
            $options['emailBlacklisted'] = $properties['emailBlacklisted'];
        }

        if (array_key_exists('smsBlacklisted', $properties)) {
            $options['smsBlacklisted'] = $properties['smsBlacklisted'];
        }

        if (array_key_exists('listIds', $properties)) {
            $options['listIds'] = $properties['listIds'];
        }

        if (array_key_exists('unlinkListIds', $properties)) {
            $options['unlinkListIds'] = $properties['unlinkListIds'];
        }

        if (array_key_exists('smtpBlacklistSender', $properties)) {
            $options['smtpBlacklistSender'] = $properties['smtpBlacklistSender'];
        }

        return $this->getContactsApi()->updateContact($email, $options);
    }

    /**
     * @param $listId
     * @param $email
     * @return \SendinBlue\Client\Model\PostContactInfo
     * @throws \SendinBlue\Client\ApiException
     */
    public function addContactToList($listId, $email)
    {
        return $this->getContactsApi()->addContactToList($listId, $email);
    }

    /**
     * @param $listId
     * @param $email
     * @return \SendinBlue\Client\Model\PostContactInfo
     * @throws \SendinBlue\Client\ApiException
     */
    public function removeContactFromList($listId, $email)
    {
        $options = [
            'emails' => [
                $email
            ]
        ];

        return $this->getContactsApi()->removeContactFromList($listId, json_encode($options));
    }

    /**
     * @param $email
     * @throws \SendinBlue\Client\ApiException
     */
    public function deleteContact($email)
    {
        return $this->getContactsApi()->deleteContact($email);
    }

    /**
     * @return \SendinBlue\Client\Model\GetFolders
     * @throws \SendinBlue\Client\ApiException
     */
    public function getFolders($limit, $offset)
    {
        return $this->getContactsApi()->getFolders($limit, $offset);
    }

    /**
     * @param $id
     * @return \SendinBlue\Client\Model\GetFolder
     * @throws \SendinBlue\Client\ApiException
     */
    public function getFolder($id)
    {
        return $this->getContactsApi()->getFolder($id);
    }

    /**
     * @param $id
     * @return \SendinBlue\Client\Model\GetFolderLists
     * @throws \SendinBlue\Client\ApiException
     */
    public function getFolderLists($id)
    {
        return $this->getContactsApi()->getFolderLists($id);
    }

    /**
     * @param $name
     * @return \SendinBlue\Client\Model\CreateModel
     * @throws \SendinBlue\Client\ApiException
     */
    public function createFolder($name)
    {
        $options = [
            'name' => $name
        ];

        return $this->getContactsApi()->createFolder(json_encode($options));
    }

    /**
     * @param $id
     * @throws \SendinBlue\Client\ApiException
     */
    public function deleteFolder($id)
    {
        return $this->getContactsApi()->deleteFolder($id);
    }

    /**
     * @return \SendinBlue\Client\Model\GetLists
     * @throws \SendinBlue\Client\ApiException
     */
    public function getLists()
    {
        return $this->getContactsApi()->getLists();
    }

    /**
     * @param $listId
     * @return \SendinBlue\Client\Model\GetExtendedList
     * @throws \SendinBlue\Client\ApiException
     */
    public function getList($listId)
    {
        return $this->getContactsApi()->getList($listId);
    }

    /**
     * @param $name
     * @param $folderId
     * @return \SendinBlue\Client\Model\CreateModel
     * @throws \SendinBlue\Client\ApiException
     */
    public function createList($name, $folderId)
    {
        $options = [
            'name' => $name,
            'folderId' => $folderId
        ];

        return $this->getContactsApi()->createList(json_encode($options));
    }

    /**
     * @param $id
     * @throws \SendinBlue\Client\ApiException
     */
    public function deleteList($id)
    {
        return $this->getContactsApi()->deleteList($id);
    }

    /**
     * @return \SendinBlue\Client\Model\GetAttributes
     * @throws \SendinBlue\Client\ApiException
     */
    public function getAttributes()
    {
        return $this->getAttributesApi()->getAttributes();
    }

    /**
     * @param $name
     * @param null $category
     * @param null $attribute
     * @throws \SendinBlue\Client\ApiException
     */
    public function createAttribute($name, $category = null, $attribute = null)
    {
        return $this->getAttributesApi()->createAttribute($category, $name, $attribute);
    }

    /**
     * @param null $category
     * @param $name
     * @throws \SendinBlue\Client\ApiException
     */
    public function deleteAttribute($category = null, $name)
    {
        return $this->getAttributesApi()->deleteAttribute($category, $name);
    }
}

<?php

namespace Damcclean\Sendinblue;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\AttributesApi;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;

class Sendinblue
{
    use Api;

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
     * Get account information.
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetAccount
     */
    public function getAccount()
    {
        return $this->getAccountApi()->getAccount();
    }

    /**
     * Get contacts.
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetContacts
     */
    public function getContacts()
    {
        return $this->getContactsApi()->getContacts();
    }

    /**
     * Get contacts from a list.
     *
     * @param $listId
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetContacts
     */
    public function getContactsFromList($listId)
    {
        return $this->getContactsApi()->getContactsFromList($listId);
    }

    /**
     * Get details of a contact.
     *
     * @param $email
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetExtendedContactDetails
     */
    public function getContactDetails($email)
    {
        return $this->getContactsApi()->getContactInfo($email);
    }

    /**
     * Create a contact.
     *
     * @param $email
     * @param null $attributes
     * @param null $listIds
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\CreateUpdateContactModel
     */
    public function createContact($email, $attributes = null, $listIds = null)
    {
        $options = [
            'email' => $email,
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
     * Get statistics of a contact.
     *
     * @param $email
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetContactCampaignStats
     */
    public function getContactStats($email)
    {
        return $this->getContactsApi()->getContactStats($email);
    }

    /**
     * Update details for a contact.
     *
     * @param $email
     * @param $properties
     *
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
     * Add a contact to a list.
     *
     * @param $listId
     * @param $email
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\PostContactInfo
     */
    public function addContactToList($listId, $email)
    {
        return $this->getContactsApi()->addContactToList($listId, $email);
    }

    /**
     * Remove a contact from a list.
     *
     * @param $listId
     * @param $email
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\PostContactInfo
     */
    public function removeContactFromList($listId, $email)
    {
        $options = [
            'emails' => [
                $email,
            ],
        ];

        return $this->getContactsApi()->removeContactFromList($listId, json_encode($options));
    }

    /**
     * Delete a contact.
     *
     * @param $email
     *
     * @throws \SendinBlue\Client\ApiException
     */
    public function deleteContact($email)
    {
        return $this->getContactsApi()->deleteContact($email);
    }

    /**
     * Get folders.
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetFolders
     */
    public function getFolders($limit, $offset)
    {
        return $this->getContactsApi()->getFolders($limit, $offset);
    }

    /**
     * Get a folder.
     *
     * @param $id
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetFolder
     */
    public function getFolder($id)
    {
        return $this->getContactsApi()->getFolder($id);
    }

    /**
     * Get lists belonging to a folder.
     *
     * @param $id
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetFolderLists
     */
    public function getFolderLists($id)
    {
        return $this->getContactsApi()->getFolderLists($id);
    }

    /**
     * Create a folder.
     *
     * @param $name
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\CreateModel
     */
    public function createFolder($name)
    {
        $options = [
            'name' => $name,
        ];

        return $this->getContactsApi()->createFolder(json_encode($options));
    }

    /**
     * Delete a folder.
     *
     * @param $id
     *
     * @throws \SendinBlue\Client\ApiException
     */
    public function deleteFolder($id)
    {
        return $this->getContactsApi()->deleteFolder($id);
    }

    /**
     * Get lists.
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetLists
     */
    public function getLists()
    {
        return $this->getContactsApi()->getLists();
    }

    /**
     * Get a list.
     *
     * @param $listId
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetExtendedList
     */
    public function getList($listId)
    {
        return $this->getContactsApi()->getList($listId);
    }

    /**
     * Create a list.
     *
     * @param $name
     * @param $folderId
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\CreateModel
     */
    public function createList($name, $folderId)
    {
        $options = [
            'name'     => $name,
            'folderId' => $folderId,
        ];

        return $this->getContactsApi()->createList(json_encode($options));
    }

    /**
     * Delete a list.
     *
     * @param $id
     *
     * @throws \SendinBlue\Client\ApiException
     */
    public function deleteList($id)
    {
        return $this->getContactsApi()->deleteList($id);
    }

    /**
     * Get attributes.
     *
     * @throws \SendinBlue\Client\ApiException
     *
     * @return \SendinBlue\Client\Model\GetAttributes
     */
    public function getAttributes()
    {
        return $this->getAttributesApi()->getAttributes();
    }

    /**
     * Create an attribute.
     *
     * @param $name
     * @param null $category
     * @param null $attribute
     *
     * @throws \SendinBlue\Client\ApiException
     */
    public function createAttribute($name, $category = null, $attribute = null)
    {
        return $this->getAttributesApi()->createAttribute($category, $name, $attribute);
    }

    /**
     * Delete an attribute.
     *
     * @param null $category
     * @param $name
     *
     * @throws \SendinBlue\Client\ApiException
     */
    public function deleteAttribute($category, $name)
    {
        return $this->getAttributesApi()->deleteAttribute($category, $name);
    }
}

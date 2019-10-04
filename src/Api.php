<?php

namespace Damcclean\Sendinblue;

use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\AttributesApi;
use SendinBlue\Client\Api\ContactsApi;

trait Api
{
    /**
     * @return AccountApi
     */
    public function getAccountApi()
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
}

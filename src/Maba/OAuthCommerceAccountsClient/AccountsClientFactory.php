<?php


namespace Maba\OAuthCommerceAccountsClient;

use Guzzle\Service\Client;
use Maba\OAuthCommerceClient\BaseClientFactory;

class AccountsClientFactory extends BaseClientFactory
{
    protected function constructClient(Client $guzzleClient)
    {
        return new AccountsClient($guzzleClient, $this->serializer);
    }

}
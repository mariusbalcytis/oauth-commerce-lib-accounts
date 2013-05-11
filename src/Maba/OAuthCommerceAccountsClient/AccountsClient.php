<?php

namespace Maba\OAuthCommerceAccountsClient;

use Maba\OAuthCommerceAccountsClient\Entity\Transaction;
use Maba\OAuthCommerceClient\BaseClient;
use Maba\OAuthCommerceClient\Command;
use Guzzle\Http\Url;
use Maba\OAuthCommerceClient\Entity\AccessToken;

class AccountsClient extends BaseClient
{
    /**
     * @param Transaction $transaction
     *
     * @return Command<Transaction>
     */
    public function createTransaction(Transaction $transaction)
    {
        return $this->createCommand()
            ->setRequest($this->client->post('transaction'))
            ->setBodyEntity($transaction, 'urlencoded')
            ->setResponseClass('Maba\OAuthCommerceAccountsClient\Entity\Transaction')
        ;
    }

    /**
     * @param string                                       $transactionKey
     * @param \Maba\OAuthCommerceClient\Entity\AccessToken $accessToken
     *
     * @return Command<Transaction>
     */
    public function getTransaction($transactionKey, AccessToken $accessToken = null)
    {
        return $this->createCommand()
            ->setAccessToken($accessToken)
            ->setRequest($this->client->get('transaction/' . $transactionKey))
            ->setResponseClass('Maba\OAuthCommerceAccountsClient\Entity\Transaction')
        ;
    }

    /**
     * @param string                                       $transactionKey
     * @param \Maba\OAuthCommerceClient\Entity\AccessToken $accessToken
     *
     * @return Command<Transaction>
     */
    public function confirmTransaction($transactionKey, AccessToken $accessToken)
    {
        return $this->createCommand()
            ->setAccessToken($accessToken)
            ->setRequest($this->client->put('transaction/' . $transactionKey . '/confirm'))
            ->setResponseClass('Maba\OAuthCommerceAccountsClient\Entity\Transaction')
        ;
    }

    /**
     * @param string                                       $transactionKey
     * @param \Maba\OAuthCommerceClient\Entity\AccessToken $accessToken
     *
     * @return Command<Transaction>
     */
    public function reserveTransaction($transactionKey, AccessToken $accessToken)
    {
        return $this->createCommand()
            ->setAccessToken($accessToken)
            ->setRequest($this->client->put('transaction/' . $transactionKey . '/reserve'))
            ->setResponseClass('Maba\OAuthCommerceAccountsClient\Entity\Transaction')
        ;
    }

    /**
     * @param string                                       $transactionKey
     * @param \Maba\OAuthCommerceClient\Entity\AccessToken $accessToken
     *
     * @return Command<Transaction>
     */
    public function revokeTransaction($transactionKey, AccessToken $accessToken)
    {
        return $this->createCommand()
            ->setAccessToken($accessToken)
            ->setRequest($this->client->delete('transaction/' . $transactionKey))
            ->setResponseClass('Maba\OAuthCommerceAccountsClient\Entity\Transaction')
        ;
    }

}
<?php


namespace Maba\OAuthCommerceAccountsClient;

use Maba\OAuthCommerceClient\AuthClient;
use Maba\OAuthCommerceClient\CodeGrantHandler;

class AccountsApi
{
    protected $authClient;
    protected $accountsClient;
    protected $codeGrantHandler;

    public function __construct(
        AuthClient $authClient,
        AccountsClient $accountsClient,
        CodeGrantHandler $codeGrantHandler
    ) {
        $this->authClient = $authClient;
        $this->accountsClient = $accountsClient;
        $this->codeGrantHandler = $codeGrantHandler;
    }

    /**
     * @return AuthClient
     */
    public function auth()
    {
        return $this->authClient;
    }

    /**
     * @return AccountsClient
     */
    public function accounts()
    {
        return $this->accountsClient;
    }

    /**
     * @return CodeGrantHandler
     */
    public function codeGrantHandler()
    {
        return $this->codeGrantHandler;
    }
}
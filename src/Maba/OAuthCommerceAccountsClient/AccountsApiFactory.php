<?php


namespace Maba\OAuthCommerceAccountsClient;

use Guzzle\Service\Client;
use Maba\OAuthCommerceClient\AuthClientFactory;
use Maba\OAuthCommerceClient\CodeGrantHandler;
use Maba\OAuthCommerceClient\Entity\SignatureCredentials;
use Maba\OAuthCommerceClient\MacSignature\AlgorithmManager;
use Maba\OAuthCommerceClient\Plugin\MacSignatureProvider;
use Maba\OAuthCommerceClient\Random\RandomProviderInterface;

class AccountsApiFactory
{
    const DEFAULT_ENDPOINT = 'https://accounts.maba.lt';

    protected $authFactory;
    protected $accountsFactory;
    protected $algorithmManager;
    protected $randomProvider;

    public function __construct(
        AuthClientFactory $authFactory,
        AccountsClientFactory $accountsFactory,
        AlgorithmManager $algorithmManager,
        RandomProviderInterface $randomProvider
    ) {
        $this->authFactory = $authFactory;
        $this->accountsFactory = $accountsFactory;
        $this->algorithmManager = $algorithmManager;
        $this->randomProvider = $randomProvider;
    }

    /**
     * @param SignatureCredentials|array $signatureCredentials
     * @param string|null                $baseUrl
     * @param array                      $config
     *
     * @return AccountsApi
     */
    public function createApi($signatureCredentials, $baseUrl = self::DEFAULT_ENDPOINT, $config = array())
    {
        if (!$signatureCredentials instanceof SignatureCredentials) {
            $signatureCredentials = $this->algorithmManager->createSignatureCredentials($signatureCredentials);
        }

        if ($baseUrl !== null) {
            $authUrl = isset($config['base_auth_url']) ? $config['base_auth_url'] : $baseUrl . '/api/auth/v1';
            $accountsUrl = isset($config['base_accounts_url'])
                ? $config['base_accounts_url']
                : $baseUrl . '/api/accounts/v1';
        } else {
            $authUrl = null;
            $accountsUrl = null;
        }
        $oauthEndpointUrl = isset($config['oauth_endpoint'])
            ? $config['oauth_endpoint']
            : ($baseUrl ? : self::DEFAULT_ENDPOINT) . '/confirm';

        return new AccountsApi(
            $this->authFactory->createClient($signatureCredentials, $authUrl, $config),
            $this->accountsFactory->createClient($signatureCredentials, $accountsUrl, $config),
            new CodeGrantHandler($this->randomProvider, $signatureCredentials->getMacId(), $oauthEndpointUrl)
        );
    }

}
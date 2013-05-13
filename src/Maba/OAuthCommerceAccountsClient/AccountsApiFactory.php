<?php


namespace Maba\OAuthCommerceAccountsClient;

use Guzzle\Service\Client;
use Maba\OAuthCommerceAccountsClient\DependencyInjection\AccountsClientExtension;
use Maba\OAuthCommerceClient\AuthClientFactory;
use Maba\OAuthCommerceClient\CodeGrantHandler;
use Maba\OAuthCommerceClient\DependencyInjection\BaseClientExtension;
use Maba\OAuthCommerceClient\Entity\SignatureCredentials;
use Maba\OAuthCommerceClient\MacSignature\AlgorithmManager;
use Maba\OAuthCommerceClient\Plugin\MacSignatureProvider;
use Maba\OAuthCommerceClient\Random\RandomProviderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

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

        $authUrl = isset($config['base_auth_url']) ? $config['base_auth_url'] : $baseUrl . '/api/auth/v1';
        $accountsUrl = isset($config['base_accounts_url'])
            ? $config['base_accounts_url']
            : $baseUrl . '/api/accounts/v1';
        $oauthEndpointUrl = isset($config['oauth_endpoint'])
            ? $config['oauth_endpoint']
            : $baseUrl . '/confirm';

        return new AccountsApi(
            $this->authFactory->createClient($signatureCredentials, $authUrl, $config),
            $this->accountsFactory->createClient($signatureCredentials, $accountsUrl, $config),
            new CodeGrantHandler($this->randomProvider, $signatureCredentials->getMacId(), $oauthEndpointUrl)
        );
    }

    public static function loadContainer(array $parameters = array(), $compile = true)
    {
        $container = new ContainerBuilder(new ParameterBag($parameters));
        $container->setResourceTracking(false); // this is not needed if cache is not used, also it requires Config

        $extension = new BaseClientExtension();
        $container->registerExtension($extension);
        $container->loadFromExtension($extension->getAlias());
        $extension->addCompilerPasses($container);
        $extension = new AccountsClientExtension();
        $container->registerExtension($extension);
        $container->loadFromExtension($extension->getAlias());

        if ($compile) {
            $container->compile();
        }
        return $container;
    }

}
<?php


namespace Maba\OAuthCommerceAccountsClient\DependencyInjection;

use Maba\OAuthCommerceClient\MacSignature\RsaAlgorithm;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class AccountsClientExtension implements ExtensionInterface
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws InvalidArgumentException When provided tag is not defined in this extension
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $container->setParameter('maba_oauth_commerce.accounts_client.default_base_url', null);

        $container
            ->setDefinition(
                'maba_oauth_commerce.factory.accounts',
                new DefinitionDecorator('maba_oauth_commerce.factory.base')
            )
            ->addMethodCall('setDefaultBaseUrl', array('%maba_oauth_commerce.accounts_client.default_base_url%'))
            ->setClass('Maba\OAuthCommerceAccountsClient\AccountsClientFactory')
        ;

        $container->register(
            'maba_oauth_commerce.factory.accounts_api',
            'Maba\OAuthCommerceAccountsClient\AccountsApiFactory'
        )->setArguments(array(
            new Reference('maba_oauth_commerce.factory.auth'),
            new Reference('maba_oauth_commerce.factory.accounts'),
            new Reference('maba_oauth_commerce.algorithm_manager'),
            new Definition('Maba\OAuthCommerceClient\Random\DefaultRandomProvider'),
        ));
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     * @return string The XML namespace
     * @api
     */
    public function getNamespace()
    {
        return $this->getAlias();
    }

    /**
     * Returns the base path for the XSD files.
     * @return string The XSD base path
     * @api
     */
    public function getXsdValidationBasePath()
    {
        return false;
    }

    /**
     * Returns the recommended alias to use in XML.
     * This alias is also the mandatory prefix to use when using YAML.
     * @return string The alias
     * @api
     */
    public function getAlias()
    {
        return 'maba_oauth_commerce_internal_client';
    }
}
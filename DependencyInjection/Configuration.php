<?php

namespace Simgroep\ConcurrentSpiderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('simgroep_concurrent_spider');

        $rootNode
            ->children()
                ->scalarNode('http_user_agent')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->defaultValue('PHP Concurrent Spider')
                    ->end()
                ->arrayNode('rabbitmq')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('host')->isRequired()->cannotBeEmpty()->defaultValue('localhost')->end()
                        ->integerNode('port')->isRequired()->cannotBeEmpty()->defaultValue('5672')->end()
                        ->scalarNode('user')->isRequired()->cannotBeEmpty()->defaultValue('guest')->end()
                        ->scalarNode('password')->isRequired()->cannotBeEmpty()->defaultValue('guest')->end()
                    ->end()
                ->end()
                ->arrayNode('queue')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('discoveredurls_queue')->isRequired()->cannotBeEmpty()->defaultValue('discovered_urls')->end()
                        ->integerNode('indexer_queue')->isRequired()->cannotBeEmpty()->defaultValue('indexer')->end()
                    ->end()
                ->end()
                ->arrayNode('solr')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('host')->isRequired()->cannotBeEmpty()->defaultValue('localhost')->end()
                        ->integerNode('port')->isRequired()->cannotBeEmpty()->defaultValue('8080')->end()
                        ->integerNode('path')->isRequired()->cannotBeEmpty()->defaultValue('/solr')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

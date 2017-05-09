<?php

namespace Mbdax\MicrosoftGraphBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        
         $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('microsoft_graph');
        $rootNode
            ->children()
                
                        ->scalarNode('client_id')->end()
                        ->scalarNode('client_secret')->end()
                        ->scalarNode('redirect_uri')->end()
                        ->scalarNode('time_zone')->end()
                        ->scalarNode('version')->end()
                        ->scalarNode('entity_manager')->end()
                        ->scalarNode('stateless')->end()
                        ->variableNode('scopes')->end()
                ->end()
                
            ->end()
        ;
        return $treeBuilder;
    }
}

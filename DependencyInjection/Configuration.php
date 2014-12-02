<?php

namespace Matks\Bundle\CustomerSupportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Customer Support Configuration
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('matks_support');

        return $treeBuilder;
    }
}

<?php

/**
 * @author Abdellah Rabh
 * @email abderabh@mail.com
 * @create date 2017-05-09 10:59:45
 * @modify date 2017-05-09 10:59:45
 * @desc [description]
*/

namespace Mbdax\MicrosoftGraphBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MicrosoftGraphExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
       
     
        $container->setParameter( 'microsoft_graph', $config);
       

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}

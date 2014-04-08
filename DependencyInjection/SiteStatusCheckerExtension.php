<?php

/*
 * This file is part of SiteStatusCheckerBundle
 *
 * (c) Alberto Fernández <albertofem@gmail.com>
 *
 * For the full copyright and license information, please read
 * the LICENSE file that was distributed with this source code.
 */

namespace AFM\Bundle\SiteStatusCheckerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SiteStatusCheckerExtension extends Extension
{
    protected $internalCheckers = array(
        'doctrine' => 'afm.site_status_checker.checker.doctrine'
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $configuration = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $container->setParameter("afm.site_status_checker.token", $configuration['token']);

        foreach($configuration['checkers'] as $checker)
        {
            if(isset($this->internalCheckers[$checker]))
            {
                $configuration[$checker] = $this->internalCheckers[$checker];
                $loader->load($checker . ".yml");
            }
        }

        $container->setParameter("afm.site_status_checker.checkers", $configuration['checkers']);

        $loader->load('services.yml');
    }
} 
<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Sylius\Bundle\CoreBundle\Application\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles(): array
    {
        $bundles = [
            new \Sylius\Bundle\AdminBundle\SyliusAdminBundle(),
            new \Sylius\Bundle\ShopBundle\SyliusShopBundle(),

            new \FOS\OAuthServerBundle\FOSOAuthServerBundle(), // Required by SyliusAdminApiBundle.
            new \Sylius\Bundle\AdminApiBundle\SyliusAdminApiBundle(),

            new \FOS\HttpCacheBundle\FOSHttpCacheBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \Netgen\Bundle\ContentBrowserBundle\NetgenContentBrowserBundle(),
            new \Netgen\Bundle\ContentBrowserUIBundle\NetgenContentBrowserUIBundle(),
            new \Netgen\Bundle\ContentBrowserSyliusBundle\NetgenContentBrowserSyliusBundle(),
            new \Netgen\Bundle\BlockManagerBundle\NetgenBlockManagerBundle(),
            new \Netgen\Bundle\BlockManagerStandardBundle\NetgenBlockManagerStandardBundle(),
            new \Netgen\Bundle\BlockManagerUIBundle\NetgenBlockManagerUIBundle(),
            new \Netgen\Bundle\BlockManagerAdminBundle\NetgenBlockManagerAdminBundle(),
            new \Netgen\Bundle\LayoutsSyliusBundle\NetgenLayoutsSyliusBundle(),

            new \AppBundle\AppBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test', 'test_cached'], true)) {
            $bundles[] = new \Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle();
            $bundles[] = new \Nelmio\Alice\Bridge\Symfony\NelmioAliceBundle();
            $bundles[] = new \Netgen\Bundle\BlockManagerDebugBundle\NetgenBlockManagerDebugBundle();
        }

        return array_merge(parent::registerBundles(), $bundles);
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->setParameter('container.autowiring.strict_mode', true);
            $container->setParameter('container.dumper.inline_class_loader', true);

            $container->addObjectResource($this);
        });

        parent::registerContainerConfiguration($loader);
    }
}

<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Popov
 * @package Popov_ZfcBlock
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */
declare(strict_types=1);

namespace Popov\ZfcBlock\Factory;

use Psr\Container\ContainerInterface;
use Zend\ServiceManager\Config;
use Popov\ZfcBlock\Plugin\BlockPluginManager;

class BlockPluginManagerFactory
{
    public function __invoke(ContainerInterface $container): BlockPluginManager
    {
        $manager = new BlockPluginManager($container);
        $config = $container->has('config') ? $container->get('config') : [];
        $config = isset($config['block_plugins']) ? $config['block_plugins'] : [];
        if (!empty($config)) {
            (new Config($config))->configureServiceManager($manager);
        }

        return $manager;
    }
}

<?php
/**
 * @category Popov
 * @package Popov_Block
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 13.11.2016 15:30
 */
namespace Popov\ZfcBlock\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Popov\ZfcBlock\View\Helper\BlockHelper;
use Popov\ZfcBlock\Plugin\BlockPluginManager;

class BlockHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        //$sm = $container->getServiceLocator();
        $bpm = $container->get(BlockPluginManager::class);
        $config = $container->get('config');
        $helper = new BlockHelper($bpm, $config);

        return $helper;
    }
}
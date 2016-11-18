<?php
/**
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 13.11.2016 15:30
 */
namespace Agere\Block\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Agere\Block\View\Helper\BlockHelper;

class BlockHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $sm = $container->getServiceLocator();
        $bpm = $sm->get('BlockPluginManager');
        $helper = new BlockHelper($bpm);

        return $helper;
    }
}
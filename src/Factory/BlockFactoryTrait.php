<?php
/**
 * Enter description here...
 *
 * @category Popov
 * @package Popov_Block
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 29.07.2016 10:29
 */
namespace Popov\ZfcBlock\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception;
use Popov\ZfcCurrent\CurrentHelper;
use Popov\ZfcBlock\Plugin\BlockPluginManager;
use Popov\ZfcBlock\Block\Core;

trait BlockFactoryTrait
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var BlockPluginManager $bpm */
        //$bpm = $this->getBlockPluginManager($container);
        //$bpm = $container->get(BlockPluginManager::class);

        //$className = $this->getClassName($container, $requestedName);

        /** @var Core $block */
        $block = new $requestedName();

        $block = $this->init(/*$bpm*/$container, $block);

        return $block;
    }

    public function init(ContainerInterface $container, $block/*, $requestedName*/)
    {
        /** @var BlockPluginManager $bpm */
        //$bpm = $this->getBlockPluginManager();
        //$sm = $bpm->getServiceLocator();
        $config = $container->get('config');

        //$routeMatch = $container->get('Application')->getMvcEvent()->getRouteMatch();

        /** @var Core $block */
        //$block = new $blockName();
        $blockName = get_class($block);
        $blockConfig = $config['block_plugin_config']['default'][$blockName] ?? [];

        if ($container->has(CurrentHelper::class)) {
            /** @var CurrentHelper $current */
            $current = $container->get(CurrentHelper::class);
            $controllerKey = $current->currentController() . '/' . $current->currentAction();

            $actionConfig = $config['block_plugin_config'][$controllerKey][$blockName] ?? [];
            $blockConfig = array_merge($blockConfig, $actionConfig);

            if (method_exists($block, 'setRenderer')) {
                $block->setRenderer($current->currentRenderer());
            }
        }

        foreach ($blockConfig as $param => $value) {
            /*if (strpos($value, '::') !== false) {
                // allow variant - 'ViewHelperManager::user', '::user'
                list($smKey, $helperKey) = explode('::', $value);
                $value = $smKey ? $container->get($smKey)->get($helperKey) : $container->get($helperKey);
            }*/
            $method = 'set' . ucfirst($param);
            $block->{$method}($value);
        }

        return $block;
    }
}
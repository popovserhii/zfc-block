<?php
/**
 * Enter description here...
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 29.07.2016 10:29
 */
namespace Agere\Block\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception;

use Agere\Block\Service\Plugin\BlockPluginManager;
use Agere\Block\Block\Core;

trait BlockFactoryTrait
{
    public function create(ServiceLocatorInterface $bpm, $blockName/*, $requestedName*/)
    {
        /** @var BlockPluginManager $bpm */
        $sm = $bpm->getServiceLocator();
        $config = $sm->get('Config');
        $routeMatch = $sm->get('Application')->getMvcEvent()->getRouteMatch();

        /** @var Core $block */
        $block = new $blockName();

        $controllerKey = $routeMatch->getParam('controller') . '/' . $routeMatch->getParam('action');
        $blockConfig = array_merge(
            isset($config['block_plugin_config']['default'][$blockName])
                ? $config['block_plugin_config']['default'][$blockName]
                : [],
            isset($config['block_plugin_config'][$controllerKey][$blockName])
                ? $config['block_plugin_config'][$controllerKey][$blockName]
                : []
        );

        foreach ($blockConfig as $key => $value) {
            if (strpos($value, '::') !== false) {
                // allow variant - "ViewHelperManager::user", "::user"
                list($smKey, $helperKey) = explode('::', $value);
                $value = $smKey ? $sm->get($smKey)->get($helperKey) : $sm->get($smKey);
            }
            $method = 'set' . ucfirst($key);
            $block->{$method}($value);
        }

        $block->setRenderer($sm->get('ViewRenderer'));

        //\Zend\Debug\Debug::dump($block); die(__METHOD__);

        return $block;
    }

    public function __invoke(ServiceLocatorInterface $bpm, $name, $requestedName)
    {
        return $this->create($bpm, $requestedName);
    }
}
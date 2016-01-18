<?php
/**
 * Block Factory
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 17.02.15 22:24
 */

namespace Agere\Block\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception;

use Agere\Block\Service\Plugin\BlockPluginManager;
use Agere\Block\Block\Core;

class BlockFactory implements AbstractFactoryInterface {

	protected $blockNames = [];


	protected function prepareBlockName($sm, $requestedName) {
		$moduleExist = function($module) use($sm) {
			$manager = $sm->getServiceLocator()->get('ModuleManager');
			$modules = $manager->getLoadedModules();

			return isset($modules[$module]);
		};

		$parts = array_map(function($part) { return ucfirst($part); }, explode('/', $requestedName));
		$module = implode('\\', array_map(function($part) { return ucfirst($part); }, explode('_', array_shift($parts))));

		if (!$moduleExist($module)) {
			$module = 'Agere\\' . $module;
		}
		$this->blockNames[$requestedName] = $module . '\\Block\\' . implode('\\', $parts);

		return $this->blockNames[$requestedName];
	}

	public function canCreateServiceWithName(ServiceLocatorInterface $sm, $name, $requestedName) {
		$blockName = isset($this->blockNames[$requestedName]) ? $this->blockNames[$requestedName] : $this->prepareBlockName($sm, $requestedName);

		return class_exists($blockName);
	}

	public function createServiceWithName(ServiceLocatorInterface $bpm, $name, $requestedName) {
		/** @var BlockPluginManager $bpm */
		/** @var Core $block */
		$sm = $bpm->getServiceLocator();
		$config = $sm->get('Config');
		$routeMatch = $sm->get('Application')->getMvcEvent()->getRouteMatch();

		$blockName = $this->blockNames[$requestedName];
		$block = new $blockName();

		$configControllerKey = $routeMatch->getParam('controller') . '/' . $routeMatch->getParam('action');
		if (isset($config['block_plugin_config'][$configControllerKey][$requestedName]['template'])) {
			$template = $config['block_plugin_config'][$configControllerKey][$requestedName]['template'];
		} elseif (!trim($block->getTemplate()) && isset($config['block_plugin_config']['default'][$requestedName]['template'])) {
			$template = $config['block_plugin_config']['default'][$requestedName]['template'];
		} /*elseif (!trim($template = $block->getTemplate())) {
			throw new Exception\InvalidArgumentException(sprintf('Template not found for block %s ("%s")', $blockName, $requestedName));
		}*/

		if (isset($template)) {
			$block->setTemplate($template);
		}
		$block->setRenderer($sm->get('viewManager')->getRenderer());

		//\Zend\Debug\Debug::dump($block); die(__METHOD__);

		return $block;
	}

}
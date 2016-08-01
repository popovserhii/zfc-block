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

class BlockAbstractFactory implements AbstractFactoryInterface {

    use BlockFactoryTrait;

	protected $blockNames = [];

	protected function prepareBlockName($bpm, $requestedName) {

		$moduleExist = function($module) use($bpm) {
			$manager = $bpm->getServiceLocator()->get('ModuleManager');
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

	public function canCreateServiceWithName(ServiceLocatorInterface $bpm, $name, $requestedName) {
		$blockName = isset($this->blockNames[$requestedName]) ? $this->blockNames[$requestedName] : $this->prepareBlockName($bpm, $requestedName);

		return class_exists($blockName);
	}

	public function createServiceWithName(ServiceLocatorInterface $bpm, $name, $requestedName) {
        /** @var BlockPluginManager $bpm */
        //$sm = $bpm->getServiceLocator();
        //$config = $sm->get('Config');
        //$routeMatch = $sm->get('Application')->getMvcEvent()->getRouteMatch();


        $blockName = $this->blockNames[$requestedName];

        $block = $this->create($bpm, $blockName);

        return $block;

        /** @var Core $block */
        $block = new $blockName();

        $getConfig = function($key) use ($config, $routeMatch, $requestedName) {
            $blockConfig = $config['block_plugin_config'];
            $configControllerKey = $routeMatch->getParam('controller') . '/' . $routeMatch->getParam('action');
            $value = false;
            if (isset($blockConfig[$configControllerKey][$requestedName][$key])) {
                $value = $blockConfig[$configControllerKey][$requestedName][$key];
            } elseif (isset($blockConfig['default'][$requestedName][$key])) {
                $value = $blockConfig['default'][$requestedName][$key];
            }

            return $value;
        };

        //$blockConfig = $config['block_plugin_config'];
		//$configControllerKey = $routeMatch->getParam('controller') . '/' . $routeMatch->getParam('action');
		/*if (isset($blockConfig[$configControllerKey][$requestedName]['template'])) {
			$templateKey = $blockConfig[$configControllerKey][$requestedName]['template'];
		} elseif (!trim($block->getTemplate()) && isset($blockConfig['default'][$requestedName]['template'])) {
			$templateKey = $blockConfig['default'][$requestedName]['template'];
		} *//*elseif (!trim($template = $block->getTemplate())) {
			throw new Exception\InvalidArgumentException(sprintf('Template not found for block %s ("%s")', $blockName, $requestedName));
		}*/

		if (!trim($block->getTemplate()) && ($templateKey = $getConfig('template'))) {
			$block->setTemplate($templateKey);
		}

		if (($accessorKey = $getConfig('accessor'))) {
            // allow variant - "ViewHelperManager:user", ":user"
            list($smKey, $helperKey) = explode(':', $accessorKey);
            $smKey ? $block->setAccessor($sm->get($smKey)->get($helperKey)) : $block->setAccessor($sm->get($smKey));
        }

		//$block->setRenderer($sm->get('ViewManager')->getRenderer());
		$block->setRenderer($sm->get('ViewRenderer'));

		//\Zend\Debug\Debug::dump($block); die(__METHOD__);

		return $block;
	}

    public function getConfig() {

    }

}
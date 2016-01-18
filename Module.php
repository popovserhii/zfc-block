<?php
/**
 * Wrapper for helper of Zend\View
 *
 * @category Agere
 * @package Agere_View
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 25.07.14 15:04
 */
namespace Agere\Block;

use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface {

	public function init(ModuleManager $moduleManager) {
		$sm = $moduleManager->getEvent()->getParam('ServiceManager');
		$serviceListener = $sm->get('ServiceListener');
		$serviceListener->addServiceManager(
			'BlockPluginManager',
			'block_plugins',
			'Agere\Block\Service\Plugin\BlockPluginProviderInterface',
			'getProjectPluginConfig'
		);
	}

	public function onBootstrap($e) {
		$e->getApplication()->getServiceManager()->get('translator');
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => str_replace('\\', '/', __DIR__ . '/src/' . __NAMESPACE__),
				),
			),
		);
	}
}
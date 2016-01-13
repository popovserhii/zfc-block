<?php
/**
 * Block helper
 *
 * @category Ageme
 * @package Ageme_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 25.04.15 21:17
 */

namespace Ageme\Block\View\Helper\Factory;

use Zend\ServiceManager\Exception;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlockFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $nm) {
		// this is not documented
		$name = func_get_args()[1];
		$requestedName = func_get_args()[2];

		$helperName = $this->helpersNamespace . '\\'. ucfirst($requestedName);

		if (!class_exists($helperName)) {
			throw new Exception\ServiceNotFoundException(sprintf(
				'%s: failed retrieving "%s%s"; class does not exist',
				get_class($this) . '::' . __FUNCTION__,
				$requestedName,
				($name ? '(alias: ' . $name . ')' : '')
			));
		}

		/** @var NavigationPluginManager $nm */
		$sm = $nm->getRenderer()->getHelperPluginManager()->getServiceLocator();
		$config = $sm->get('Config');

		$helper = new $helperName();
		if (isset($config['navigation_helper_config'][$requestedName])) {
			$helperConfig = $config['navigation_helper_config'][$requestedName];
			$this->setParameters($helperConfig, $helper);
		}

		return $helper;
	}

}
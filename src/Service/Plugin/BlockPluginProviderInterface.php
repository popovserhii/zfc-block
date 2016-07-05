<?php
/**
 * Plugin Provider Interface
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 09.03.15 22:50
 */

namespace Agere\Block\Service\Plugin;

interface BlockPluginProviderInterface {

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getBlockPluginConfig();

}
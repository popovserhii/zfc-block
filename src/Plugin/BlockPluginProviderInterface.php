<?php
/**
 * Plugin Provider Interface
 *
 * @category Popov
 * @package Popov_Block
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 09.03.15 22:50
 */

namespace Popov\ZfcBlock\Plugin;

interface BlockPluginProviderInterface {

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getBlockPluginConfig();

}
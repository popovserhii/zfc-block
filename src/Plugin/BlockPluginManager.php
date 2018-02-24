<?php
/**
 * Plugin Manager
 *
 * @category Popov
 * @package Popov_Block
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 09.03.15 21:29
 */

namespace Popov\ZfcBlock\Plugin;

use Zend\Stdlib\Exception;
use Zend\ServiceManager\AbstractPluginManager;

class BlockPluginManager extends AbstractPluginManager {

	/**
	 * Default set of extension classes
	 * Note: Use config notation for more flexibility
	 *
	 * @var array
	 */
	protected $invokableClasses = [];

	public function validate($plugin) {
		if ($plugin instanceof BlockPluginInterface) {
			// we're okay
			return;
		}
		
		throw new Exception\RuntimeException(sprintf(
			'Plugin of type %s is invalid; must implement %s\BlockPluginInterface',
			(is_object($plugin) ? get_class($plugin) : gettype($plugin)),
			__NAMESPACE__
		));
	}
}

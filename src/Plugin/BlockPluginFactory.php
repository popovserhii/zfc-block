<?php
/**
 * Plugin Factory
 *
 * @category Popov
 * @package Popov_Block
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 09.03.15 21:55
 */

namespace Popov\ZfcBlock\Plugin;

use Zend\Mvc\Service\AbstractPluginManagerFactory;
use Popov\ZfcBlock\Plugin\BlockPluginManager;

class BlockPluginFactory extends AbstractPluginManagerFactory {

	const PLUGIN_MANAGER_CLASS = BlockPluginManager::class;

}
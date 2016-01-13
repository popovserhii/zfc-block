<?php
/**
 * Plugin Factory
 *
 * @category Ageme
 * @package Ageme_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 09.03.15 21:55
 */

namespace Ageme\Block\Service\Plugin;

use Zend\Mvc\Service\AbstractPluginManagerFactory;

class BlockPluginFactory extends AbstractPluginManagerFactory {

	const PLUGIN_MANAGER_CLASS = 'Ageme\Block\Service\Plugin\BlockPluginManager';

}
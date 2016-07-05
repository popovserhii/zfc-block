<?php
/**
 * Plugin Factory
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 09.03.15 21:55
 */

namespace Agere\Block\Service\Plugin;

use Zend\Mvc\Service\AbstractPluginManagerFactory;

class BlockPluginFactory extends AbstractPluginManagerFactory {

	const PLUGIN_MANAGER_CLASS = 'Agere\Block\Service\Plugin\BlockPluginManager';

}
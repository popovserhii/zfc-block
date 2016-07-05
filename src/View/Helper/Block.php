<?php
/**
 * Block helper
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 25.04.15 21:17
 */
namespace Agere\Block\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager;

class Block extends AbstractHelper implements ServiceLocatorAwareInterface {

	use ServiceLocatorAwareTrait;

	/**
	 * Last block object has called through __invoke
	 * @var
	 */
	protected $block;

	public function render($block = null) {
		if (!$block) {
			$block = $this->getCurrent();
		}

		return $this->getView()->partial($block->getTemplate(), ['block' => $block]);
	}

	public function getTemplate() {

	}

	public function getCurrent() {
		return $this->block;
	}

	public function get($name) {
		/** @var ServiceManager $bpm */
		$bpm = $this->serviceLocator->getServiceLocator()->get('BlockPluginManager');
		//$sm = $this->getServiceLocator();
		//\Zend\Debug\Debug::dump(get_class($sm)); die(__METHOD__);

		return $bpm->get($name);
	}

    public function __invoke() {
		$args = func_get_args();
		if (!$args) {
			return $this;
		}
		$this->block = $this->get($args[0]);

		return $this->block;
    }
}
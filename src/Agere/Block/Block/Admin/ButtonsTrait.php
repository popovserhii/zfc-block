<?php
/**
 * Buttons Trait
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 10.05.15 12:39
 */

namespace Agere\Block\Block\Admin;

use Zend\Stdlib\Exception;

trait ButtonsTrait {

	protected $buttons = [];

	protected $buttonsWrapperClass = '';

	protected $buttonsTemplate = 'block/buttons';

	public function buttons() {
		return $this->buttons;
	}

	/**
	 * @param $name
	 * @param array $attributes
	 * @return $this
	 */
	public function button($name, array $attributes = []) {
		$this->buttons[$name] = $attributes;

		return $this;
	}

	/**
	 * @param $name
	 * @param array $attributes
	 * @return $this
	 * @throws Exception\InvalidArgumentException
	 */
	public function addButton($name, $attributes = []) {

		/*try {
			throw new \Exception('Many initialization of toolbar1');
		} catch (\Exception $e) {
			\Zend\Debug\Debug::dump($e->getMessage());
			\Zend\Debug\Debug::dump($e->getTraceAsString());
			//die(__METHOD__);

			$writer = new \Zend\Log\Writer\Stream('./logfile');
			$logger = new \Zend\Log\Logger();
			$logger->addWriter($writer);
			$logger->info(\Zend\Debug\Debug::dump($this->buttons, '$this->buttons', false));
			$logger->info($e->getMessage());
			$logger->info($e->getTraceAsString());
			$logger->info('------------------------');
		}*/





		if (isset($this->buttons[$name])) {
			/*try {
				throw new \Exception('Many initialization of toolbar2');
			} catch (\Exception $e) {
				\Zend\Debug\Debug::dump($e->getMessage());
				\Zend\Debug\Debug::dump($e->getTraceAsString());

				$writer = new \Zend\Log\Writer\Stream('./logfile');
				$logger = new \Zend\Log\Logger();
				$logger->addWriter($writer);
				$logger->info($e->getMessage());
				$logger->info($e->getTraceAsString());
				$logger->info('------------------------');

				die(__METHOD__);
			}*/


			throw new Exception\InvalidArgumentException(sprintf('Button with name %s already exist if you want overwrite this use %s instead of',
				$name,
				__CLASS__ . '::buttons()'
			));
		}

		return $this->button($name, $attributes);
	}

	public function resetButtonsWrapperClass() {
		$this->buttonsWrapperClass = '';
	}
	public function addButtonsWrapperClass($class) {
		$this->buttonsWrapperClass .= $class;
	}

	public function getButtonsWrapperClass() {
		return $this->buttonsWrapperClass;
	}

	public function setButtonsTemplate($template) {
		$this->buttonsTemplate = $template;
	}

	public function getButtonsTemplate() {
		return $this->buttonsTemplate;
	}

}
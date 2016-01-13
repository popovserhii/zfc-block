<?php
/**
 * Buttons Trait
 *
 * @category Ageme
 * @package Ageme_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 10.05.15 12:39
 */

namespace Ageme\Block\Block\Admin;

use Zend\Stdlib\Exception;

trait ButtonsTrait {

	protected $buttons = [];

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
		if (isset($this->buttons[$name])) {
			throw new Exception\InvalidArgumentException(sprintf('Button with name %s already exist if you want overwrite this use %s instead of',
				$name,
				__CLASS__ . '::buttons()'
			));
		}

		return $this->button($name, $attributes);
	}

}
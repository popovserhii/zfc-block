<?php
/**
 * Action panel for admin block
 *
 * Like Twitter Bootstrap toggle drop-down element
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 25.04.15 23:31
 */

namespace Agere\Block\Block\Admin;

use Zend\Stdlib\Exception;

use Agere\Block\Block\Core;
use Agere\ArrayEx\ArrayEx;

class ActionPanel extends Core {

	const OPT_ENABLE_CHECK = true;

	const OPT_DISABLE_CHECK = false;

	//protected $name = 'Action';

	protected $template = 'block/action-panel';

	/**
	 * @var array
	 */
	protected $actions = [];


	public function setName($name) {
		return $this->set('name', $name ?: 'Action');
	}

	public function getName() {
		return $this->get('name');
	}

	/**
	 * @param $name
	 * @param $url
	 * @param array $options
	 * @param bool $checkOptions
	 * @return $this
	 */
	public function setAction($name, $url, $options = [], $checkOptions = self::OPT_ENABLE_CHECK) {
		if ($checkOptions) {
			$options = $this->prepareOptions($options);
		}
		$this->actions[$options['group']][$options['position']][][$name] = $url;

		return $this;
	}

	/**
	 * @param string $name
	 * @param string $url
	 * @param array $options
	 * @return $this
	 * @throws Exception\InvalidArgumentException
	 */
	public function addAction($name, $url, $options = []) {
		$options = $this->prepareOptions($options);
		$position = isset($this->actions[$options['group']][$options['position']])
			? $this->actions[$options['group']][$options['position']]
			: false;

		if ($position && (new ArrayEx($position))->in($name)) {
			throw new Exception\InvalidArgumentException(sprintf('Action with name %s already exist if you want overwrite this use %s instead of',
				$name,
				__CLASS__ . '::setAction()'
			));
		}

		return $this->setAction($name, $url, $options, self::OPT_DISABLE_CHECK);
	}

	public function groups() {
		return array_keys($this->actions);
	}

	public function actions($group = null) {
		if ((is_null($group) === false) && isset($this->actions[$group])) {
			$positions = $this->actions[$group];
			sort($positions);
			$actions = [];
			foreach ($positions as $position => $action) {
				$actions = array_merge($actions, $action);
			}
			return $actions;
		} elseif (!is_null($group)) {
			return false;
		}

		return $this->actions;
	}

	protected function prepareOptions($options) {
		$options['group'] = isset($options['group']) ? $options['group'] : 'default';
		$options['position'] =  isset($options['position']) ? $options['position'] : 100;

		return $options;
	}

}
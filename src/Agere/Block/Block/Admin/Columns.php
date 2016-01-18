<?php
/**
 * Columns of list items
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 27.04.15 17:10
 */

namespace Agere\Block\Block\Admin;

use Zend\Stdlib\Exception;
use Agere\Base\Plugin\ArrayUtilss;

class Columns {

	/**
	 * Collection of items
	 *
	 * @var \Countable
	 */
	protected $items = null;

	/**
	 * Cells for showing
	 *
	 * @var array
	 */
	protected $displayed = [];

	protected $positions = ['before' => [], 'after' => []];

	protected $factory = null;

	public function items($items = null) {
		if (is_null($items)) {
			return $this->items;
		}
		$this->items = $items;

		return $this;
	}


	/**
	 * Show field from item
	 *
	 * @param $name
	 * @return Column\Column
	 */
	public function show($name) {
		if (!isset($this->displayed[$name])) {
			$this->displayed[$name] = $this->getFactory()->create($name);
		}

		return $this->displayed[$name];
	}

	/**
	 * Column position
	 * For example:
	 *  'color', 'before', 'name'
	 *  'year', 'after', '__delete'
	 *
	 * @param $field
	 * @param $position
	 * @param $relative
	 * @return $this
	 * @throws Exception\InvalidArgumentException
	 */
	public function position($field, $position, $relative) {
		if (!isset($this->positions[$position])) {
			throw new Exception\InvalidArgumentException(sprintf('Position %s is not allowed', $position));
		}
		$this->positions[$position][$field] = $relative;

		return $this;
	}

	public function setFactory($factory) {
		$this->factory = $factory;

		return $this;
	}

	public function getFactory() {
		if (!$this->factory) {
			$this->factory = new Column\ColumnFactory();
		}
		return $this->factory;
	}

	/**
	 * @param $name
	 * @return Column\Column
	 */
	public function get($name) {
		return $this->displayed[$name];
	}

	public function order() {
		$columns = array_keys($this->displayed);
		if (!$this->positions['before'] && !$this->positions['after']) {
			return $columns;
		}

		foreach ($this->positions as $position => $positioned) {
			foreach($positioned as $columnName => $relative) {
				$columns[array_search($columnName, $columns)] = '';
				$indexNew = array_search($relative, $columns);

				if ($position === 'before') {
					array_splice($columns, $indexNew, 0, $columnName);
				} elseif ($position === 'after') {
					array_splice($columns, $indexNew + 1, 0, $columnName);
				}
			}
		}

		return array_filter($columns);
	}

	public function displayed() {
		return $this->displayed;
	}

}
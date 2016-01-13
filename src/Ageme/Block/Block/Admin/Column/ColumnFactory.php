<?php
/**
 * Enter description here...
 *
 * @category Agere
 * @package Agere_<package>
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 07.05.15 10:54
 */

namespace Ageme\Block\Block\Admin\Column;

use Ageme\Block\Block\Admin\Column;

class ColumnFactory {

	protected $specColumn = [
		'__default' => 'Column',
		'__sequence' => 'Sequence',
		'__checkbox' => 'Checkbox',
	];

	public function create($name) {
		$class = isset($this->specColumn[$name]) ? $this->specColumn[$name] : $this->specColumn['__default'];
		$className = __NAMESPACE__ . '\\' . $class;

		return new $className($name);
	}

}
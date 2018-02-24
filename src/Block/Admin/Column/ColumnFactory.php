<?php
/**
 * Enter description here...
 *
 * @category Popov
 * @package Popov_<package>
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 07.05.15 10:54
 */

namespace Popov\ZfcBlock\Block\Admin\Column;

use Popov\ZfcBlock\Block\Admin\Column;

/**
 * Class ColumnFactory
 *
 * @deprecated
 */
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
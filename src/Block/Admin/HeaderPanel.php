<?php
/**
 * Enter description here...
 *
 * @category Popov
 * @package Popov_<package>
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 10.05.15 11:56
 */

namespace Popov\ZfcBlock\Block\Admin;

class HeaderPanel {

	use ButtonsTrait;

	protected $title;


	public function title($title = null) {
		if (is_null($title)) {
			return $this->title;
		}
		$this->title = $title;

		return $this;
	}

}
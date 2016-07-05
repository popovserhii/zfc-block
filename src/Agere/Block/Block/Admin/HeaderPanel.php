<?php
/**
 * Enter description here...
 *
 * @category Agere
 * @package Agere_<package>
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 10.05.15 11:56
 */

namespace Agere\Block\Block\Admin;

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
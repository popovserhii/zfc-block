<?php
/**
 * Sequence column
 *
 * @category Ageme
 * @package Ageme_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 07.05.15 10:56
 */

namespace Ageme\Block\Block\Admin\Column;


class Sequence extends Column {

	public function renderLabel($item) {
		static $i;
		if (!$i) {
			$i = ($num = (int) parent::renderLabel($item)) ? $num : 1;
		}

		return $i++;
	}

}
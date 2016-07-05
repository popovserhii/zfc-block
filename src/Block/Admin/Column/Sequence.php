<?php
/**
 * Sequence column
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 07.05.15 10:56
 */

namespace Agere\Block\Block\Admin\Column;


class Sequence extends Column {

	public function renderLabel($item) {
		static $i;
		if (!$i) {
			$i = ($num = (int) parent::renderLabel($item)) ? $num : 1;
		}

		return $i++;
	}

}
<?php
/**
 * Sequence column
 *
 * @category Popov
 * @package Popov_Block
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 07.05.15 10:56
 */

namespace Popov\ZfcBlock\Block\Admin\Column;


class Sequence extends Column {

	public function renderLabel($item) {
		static $i;
		if (!$i) {
			$i = ($num = (int) parent::renderLabel($item)) ? $num : 1;
		}

		return $i++;
	}

}
<?php
/**
 * Navigation panel
 *
 * @category Popov
 * @package Popov_Block
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 10.05.15 11:57
 */

namespace Popov\ZfcBlock\Block\Admin;

use Zend\Stdlib\Exception;

class NavPanel {

	use ButtonsTrait;

	/**
	 * Available: both, before, after
	 *
	 * @var string
	 */
	protected $paginationPosition = 'both';


	/**
	 * Pagination visibility
	 *
	 * @param $position
	 * @return $this
	 * @throws Exception\InvalidArgumentException
	 */
	public function paginationPosition($position = null) {
		if (is_null($position)) {
			return $this->paginationPosition;
		}

		static $available = ['both', 'before', 'after'];
		if (!in_array($position, $available)) {
			throw new Exception\InvalidArgumentException(sprintf('Unavailable pagination position %s. Use instead: %s',
				$position,
				implode(', ', $available)
			));
		}
		$this->paginationPosition = $position;

		return $this;
	}

}
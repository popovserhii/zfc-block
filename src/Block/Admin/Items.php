<?php
/**
 * Enter description here...
 *
 * @category Popov
 * @package Popov_<package>
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 25.04.15 21:37
 */

namespace Popov\ZfcBlock\Block\Admin;

use Popov\ZfcBlock\Block\Core;

class Items extends Core {

	protected $headerPanel;

	protected $actionPanel;

	protected $navPanel;

	protected $columns;


	public function setActionPanel($actionPanel) {
		$this->actionPanel = $actionPanel;

		return $this;
	}

	public function getActionPanel() {
		if (!$this->actionPanel) {
			$this->actionPanel = new ActionPanel();
		}

		return $this->actionPanel;
	}

	public function setHeaderPanel($headerPanel) {
		$this->headerPanel = $headerPanel;

		return $this;
	}

	public function getHeaderPanel() {
		if (!$this->headerPanel) {
			$this->headerPanel = new HeaderPanel();
		}

		return $this->headerPanel;
	}

	public function setNavPanel($navPanel) {
		$this->navPanel = $navPanel;

		return $this;
	}

	public function getNavPanel() {
		if (!$this->navPanel) {
			$this->navPanel = new NavPanel();
		}

		return $this->navPanel;
	}

	public function setColumns($columns) {
		$this->columns = $columns;

		return $this;
	}

	public function getColumns() {
		if (!$this->columns) {
			$this->columns = new Columns();
		}

		return $this->columns;
	}

	public function columns() {
		return $this->getColumns();
	}


}

<?php
/**
 * Enter description here...
 *
 * @category Agere
 * @package Agere_<package>
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 25.04.15 21:37
 */

namespace Ageme\Block\Block\Admin;

use Ageme\Block\Block\Core;

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

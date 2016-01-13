<?php
/**
 * Enter description here...
 *
 * @category Agere
 * @package Agere_<package>
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 27.04.15 17:33
 */

namespace Ageme\Block\Block\Admin\Column;


class Column {

	/**
	 * Column name
	 *
	 * @var string
	 */
	protected $name;

	protected $label;

	protected $link;

	protected $wrap;

	protected $headTemplate;


	public function __construct($name) {
		$this->name = $name;
	}

	public function headTemplate($template = null) {
		if (is_null($template)) {
			return $this->headTemplate;
		}
		$this->headTemplate = $template;

		return $this->headTemplate;
	}

	public function name($name = null) {
		if (is_null($name)) {
			return $this->name;
		}
		$this->name = $name;

		return $this;
	}

	/**
	 * @param string|closure $label
	 * @return $this
	 */
	public function label($label) {
		$this->label = $label;

		return $this;
	}

	/**
	 * @param string|closure $link
	 * @return $this
	 */
	public function link($link) {
		$this->link = $link;

		return $this;
	}

	/**
	 * Additional content pattern
	 * For example:
	 * 	input: $block->column()->show('name')->link('http://example.com')->wrap('%s <span>&lg;</span>');
	 * 	output: <a href="http://example.com"><%item name%></a> <span>&lg;</span>
	 *
	 * @param string|closure $wrap
	 * @return $this
	 */
	public function wrap($wrap) {
		$this->wrap = $wrap;

		return $this;
	}

	public function isClosure($closure) {
		return is_object($closure) && ($closure instanceof \Closure);
	}

	public function render($item) {
		$label = $this->renderLabel($item);
		$label = $this->renderLink($item, $label);
		$label = $this->renderWrap($item, $label);

		return $label;
	}

	public function renderLabel($item) {
		$labelVal = '';
		$label = $this->label;
		if ($label) {
			$labelVal = $this->isClosure($label) ? $label($item) : $label;
		} elseif (method_exists($item, $method = 'get' . ucfirst($this->name()))) {
			$labelVal = $item->{$method}();
		}

		return $labelVal;
	}

	public function renderLink($item, $label) {
		if ($link = $this->link) {
			$linkVal = $this->isClosure($link) ? $link($item) : $link;
			$label = sprintf('<a href="%s">%s</a>', $linkVal, $label);
		}

		return $label;
	}

	public function renderWrap($item, $label) {
		if ($wrap = $this->wrap) {
			$wrapVal = $this->isClosure($wrap) ? $wrap($item) : $wrap;
			$label = sprintf($wrapVal, $label);
		}

		return $label;
	}

	public function renderHead($renderer) {
		return $this->name;
	}

}
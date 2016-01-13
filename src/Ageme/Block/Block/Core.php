<?php
/**
 * Core block
 *
 * @category Ageme
 * @package Ageme_View
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 13.04.15 16:09
 */

namespace Ageme\Block\Block;

use Ageme\Block\Service\Plugin\BlockPluginInterface;

class Core implements BlockPluginInterface {

	protected $renderer;

	protected $header = '';

	protected $template = '';

	protected $translatorTextDomain = null;

	protected $data = [];


	public function setTemplate($template) {
		$this->template = $template;
	}

	public function getTemplate() {
		return $this->template;
	}

	public function setTranslatorTextDomain($translator) {
		$this->translatorTextDomain = $translator;
	}

	public function getTranslatorTextDomain() {
		return $this->translatorTextDomain;
	}

	public function renderAttrs($attrs) {
		$attrsStr = '';
		foreach ($attrs as $name => $value) {
			if ($value) {
				$attrsStr .= sprintf('%s="%s"', $name, $value);
			} else {
				$attrsStr .= $name . '';
			}
		}

		return $attrsStr;
	}

	public function set($name, $value) {
		$this->data[$name] = $value;
	}

	public function setRenderer($renderer) {
		$this->renderer = $renderer;

		return $this;
	}

	public function getRenderer() {
		return $this->renderer;
	}

	public function get($name) {
		return isset($this->data[$name]) ? $this->data[$name] : null;
	}

	public function render() {
		return $this->getRenderer()->render($this->template, ['block' => $this]);
	}
}
<?php
/**
 * Delete column
 *
 * @category Ageme
 * @package Ageme_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 07.05.15 10:56
 */

namespace Ageme\Block\Block\Admin\Column;

use Zend\Stdlib\Exception;

class Checkbox extends Column {

	protected $headTemplate = 'block/actionPanel';

	protected $actionBlock;


	protected function getName($item) {
		static $cache;
		$hash = spl_object_hash($item);
		if (!isset($cache[$hash])) {
			$className = get_class($item);
			$delimeter = 'Document\\'; // @todo can exclude to config
			$delimeterPos = strpos($className, $delimeter);

			if (false === $delimeterPos) {
				throw new Exception\RuntimeException(sprintf('Cannot determine name for checkbox. Not found delimeter "%s" in class name: %s',
					$delimeter,
					$className
				));
			}

			$name = substr($className, $delimeterPos + strlen($delimeter));
			$cache[$hash] = $name;
			//\Zend\Debug\Debug::dump($name); die(__METHOD__);
		}

		return $cache[$hash];
	}

	public function actionPanel($actionBlock = null) {
		if (is_null($actionBlock)) {
			return $this->actionBlock;
		}
		$this->actionBlock = $actionBlock;

		return $this;
	}

	public function renderLabel($item) {
		$input = sprintf('<input type="checkbox" value="%s" name="%s[]" />', $item->getId(), $this->getName($item));

		return $input;
	}

	public function renderHead($renderer) {
		return $renderer->render($this->headTemplate, ['block' => $this->actionBlock]);
	}

}
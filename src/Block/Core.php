<?php
/**
 * Core block
 *
 * @category Agere
 * @package Agere_View
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 13.04.15 16:09
 */
namespace Agere\Block\Block;

use Zend\View\Helper\Url;
use Zend\Stdlib\Exception\LogicException;
use Agere\Block\Service\Plugin\BlockPluginInterface;

class Core implements BlockPluginInterface
{
    protected $renderer;

    protected $header = '';

    protected $template = '';

    protected $translatorTextDomain = null;

    protected $accessor;

    protected $data = [];

    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTranslatorTextDomain($translator)
    {
        $this->translatorTextDomain = $translator;

        return $this;
    }

    public function getTranslatorTextDomain()
    {
        return $this->translatorTextDomain;
    }

    /**
     * Set object which check access to resource
     *
     * @param $accessor Object must implement only one method "hasAccess($resource)"
     * @return $this
     */
    public function setAccessor($accessor)
    {
        $this->accessor = $accessor;

        return $this;
    }

    public function getAccessor()
    {
        return $this->accessor;
    }

    public function hasAccess($params)
    {
        if (($accessor = $this->getAccessor())) {
            /** @var Url $urlPlugin */
            $urlPlugin = $this->getRenderer()->plugin('url');
            $route = key($params);
            $params = current($params);
            $resource = $urlPlugin($route, $params);
            if (!$accessor->hasAccess($resource)) {
                return false;
            }
        }
        return true;
    }

    public function renderAttrs($attrs)
    {
        if (!is_array($attrs)) {
            return false;
        }
        $attrsStr = '';
        //\Zend\Debug\Debug::dump($attrs);
        foreach ($attrs as $name => $value) {
            $attrsStr .= $this->renderAttr($name, $value);
        }

        return $attrsStr;
    }

    public function renderAttr($name, $value)
    {
        $attr = '';
        if ($value) {
            $attr .= sprintf('%s="%s"', $name, $value);
        } else {
            $attr .= $name . '';
        }

        return $attr;
    }

    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;

        return $this;
    }

    public function getRenderer()
    {
        return $this->renderer;
    }

    public function set($name, $value)
    {
        $this->data[$name] = $value;

        return $this;
    }

    public function get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * @deprecated Instead use View Block Helper $this->block()->render($block)
     */
    public function render()
    {
        throw new LogicException(sprintf('Method %s is redundant for this class.
			Instead use View Block Helper: $this->block()->render($block)', __METHOD__));
        //return $this->getRenderer()->render($this->template, ['block' => $this]);
    }
}
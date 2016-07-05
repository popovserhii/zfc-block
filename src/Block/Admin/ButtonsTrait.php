<?php
/**
 * Buttons Trait
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 10.05.15 12:39
 */
namespace Agere\Block\Block\Admin;

use Zend\Stdlib\Exception;

trait ButtonsTrait
{
    protected $buttons = [];

    protected $buttonsWrapperClass = '';

    protected $buttonsTemplate = 'block/buttons';

    public function buttons()
    {
        return $this->buttons;
    }

    /**
     * @param $name
     * @param array $attributes
     * @return $this
     */
    public function button($name, array $attributes = [])
    {
        // check access to resource
        if ($this->accessExists() && isset($attributes['href']) && !$this->hasAccess($attributes['href'])) {
            return $this;
        }

        $this->buttons[$name] = $attributes;

        return $this;
    }

    /**
     * @param $name
     * @param array $attributes
     * @return $this
     * @throws Exception\InvalidArgumentException
     */
    public function addButton($name, $attributes = [])
    {
        if (isset($this->buttons[$name])) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Button with name %s already exist if you want overwrite this use %s instead of',
                $name,
                __CLASS__ . '::buttons()'
            ));
        }

        return $this->button($name, $attributes);
    }

    public function removeButton($name)
    {
        unset($this->buttons[$name]);

        return $this;
    }

    public function accessExists()
    {
        static $exists = null;

        if (null !== $exists) {
            return $exists;
        }

        $exists = method_exists($this, 'hasAccess');

        return $exists;
    }

    public function resetButtonsWrapperClass()
    {
        $this->buttonsWrapperClass = '';
    }

    public function addButtonsWrapperClass($class)
    {
        $this->buttonsWrapperClass .= $class;
    }

    public function getButtonsWrapperClass()
    {
        return $this->buttonsWrapperClass;
    }

    public function setButtonsTemplate($template)
    {
        $this->buttonsTemplate = $template;
    }

    public function getButtonsTemplate()
    {
        return $this->buttonsTemplate;
    }
}
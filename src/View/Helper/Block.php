<?php
/**
 * Block helper
 *
 * @category Agere
 * @package Agere_Block
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 25.04.15 21:17
 */
namespace Agere\Block\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager;

class Block extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function render($block)
    {
        return $this->getView()->partial($block->getTemplate(), ['block' => $block]);
    }

    public function getTemplate()
    {
    }

    public function get($name)
    {
        /** @var ServiceManager $bpm */
        $bpm = $this->serviceLocator->getServiceLocator()->get('BlockPluginManager');
        //$sm = $this->getServiceLocator();
        //\Zend\Debug\Debug::dump(get_class($sm)); die(__METHOD__);
        return $bpm->get($name);
    }

    public function __invoke()
    {
        $args = func_get_args();
        if (!$args) {
            return $this;
        }

        $name = $args[0];
        $variables = isset($args[1]) ? $args[1] : [];

        $block = $this->get($name);

        foreach ($variables as $key => $value) {
            $block->set($key, $value);
        }

        return $block;
    }
}
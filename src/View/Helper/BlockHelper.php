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

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\View\Helper\AbstractHelper;
//use Zend\ServiceManager\ServiceLocatorAwareInterface;
//use Zend\ServiceManager\ServiceLocatorAwareTrait;
//use Zend\ServiceManager\ServiceManager;
use Agere\Block\Service\Plugin\BlockPluginManager;

class BlockHelper extends AbstractHelper implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /** @var BlockPluginManager */
    protected $blockPluginManager;

    public function __construct(BlockPluginManager $blockPluginManager)
    {
        $this->blockPluginManager = $blockPluginManager;
    }

    public function getBlockPluginManager()
    {
        return $this->blockPluginManager;
    }

    public function getTemplate()
    {
    }

    public function render($block)
    {
        return $this->getView()->partial($block->getTemplate(), ['block' => $block]);
    }

    public function get($name)
    {
        $bpm = $this->getBlockPluginManager();

        return $bpm->get($name);
    }

    public function create($name, $variables = [])
    {
        $block = $this->get($name);

        $this->getEventManager()->trigger(__FUNCTION__ . 'on', $block);
        foreach ($variables as $key => $value) {
            $block->set($key, $value);
        }
        $this->getEventManager()->trigger(__FUNCTION__, $block);


        return $block;
    }

    public function __invoke()
    {
        $args = func_get_args();
        if (!$args) {
            return $this;
        }

        $name = $args[0];
        $variables = isset($args[1]) ? $args[1] : [];

        return $this->create($name, $variables);
    }
}
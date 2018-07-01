<?php
/**
 * Block helper
 *
 * @category Popov
 * @package Popov_ZfcBlock
 * @author Serhii Popov <popow.serhii@gmail.com>
 */

namespace Popov\ZfcBlock\View\Helper;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\Exception;
use Popov\ZfcBlock\Plugin\BlockPluginManager;

class BlockHelper extends AbstractHelper implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    protected $config;

    /** @var BlockPluginManager */
    protected $blockPluginManager;

    public function __construct(BlockPluginManager $blockPluginManager, array $config)
    {
        $this->config = $config;
        $this->blockPluginManager = $blockPluginManager;
    }

    public function getBlockPluginManager()
    {
        return $this->blockPluginManager;
    }

    public function render($block)
    {
        if (is_string($block)) {
            $block = $this->create($block);
        }
        return $this->getView()->partial($block->getTemplate(), ['block' => $block]);
    }

    public function get($name)
    {
        $bpm = $this->getBlockPluginManager();
        $className = $this->getClassName($name);

        return $bpm->get($className);
    }

    public function create($name, $variables = [])
    {
        $block = $this->get($name);
        //$this->getEventManager()->trigger(__FUNCTION__ . 'on', $block);
        foreach ($variables as $key => $value) {
            $block->set($key, $value);
        }
        $this->getEventManager()->trigger(__FUNCTION__, $block);

        return $block;
    }

    public function getClassName($requestedName)
    {
        $aliases = $this->config['block_plugins']['aliases'];
        $fullName = isset($aliases[$requestedName]) ? $aliases[$requestedName] : '';

        if ((!$existsRequested = class_exists($requestedName)) && (!$existsFull = class_exists($fullName))) {
            throw new Exception\ServiceNotFoundException(sprintf(
                '%s: failed retrieving "%s"; class does not exist',
                get_class($this) . '::' . __FUNCTION__,
                $requestedName
            //($name ? '(alias: ' . $name . ')' : '')
            ));
        }
        $className = $existsRequested ? $requestedName : $fullName;

        return $className;
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
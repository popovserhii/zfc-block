<?php
/**
 * Toolbar panel is wrapper block which include:
 * ActionPanel, NavPanel, Buttons etc.
 *
 * @category Popov
 * @package Popov_Block
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 13.01.2016 22:10
 */
namespace Popov\ZfcBlock\Block\Admin;

use Popov\ZfcBlock\Block\Core;

class Toolbar extends Core
{
    use ButtonsTrait;

    /** @var ActionPanel[] */
    protected $actionPanels;

    /** @var  NavPanel */
    protected $navPanel; // @todo

    protected $template = 'block/toolbar';

    public function addActionPanel(ActionPanel $actionPanel, $captureTo = '')
    {
        $this->captureTo($actionPanel, $captureTo);

        return $this;
    }

    public function setActionPanels(array $actionPanels)
    {
        $this->actionPanels = $actionPanels;

        return $this;
    }

    public function getActionPanels()
    {
        return $this->actionPanels;
    }

    /**
     * @param string $captureTo
     * @return ActionPanel
     * @toto Implement Lite way factory for new ActionPanel()
     */
    public function createActionPanel($captureTo = '')
    {
        $actionPanel = new ActionPanel();
        $actionPanel->setRenderer($this->getRenderer());
        $actionPanel->setAccessor($this->getAccessor());
        $actionPanel->setTranslatorTextDomain($this->getTranslatorTextDomain());

        !$captureTo || $actionPanel->setName($captureTo);
        $this->captureTo($actionPanel, $captureTo);

        return $actionPanel;
    }

    protected function captureTo($actionPanel, $captureTo)
    {
        if ($captureTo) {
            $this->actionPanels[$captureTo] = $actionPanel;
        } else {
            $this->actionPanels[] = $actionPanel;
        }
    }
}
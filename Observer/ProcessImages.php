<?php
/**
 * This file is part of Scaleflex Cloudimage
 *
 * @author Alyzeo LTD <info@alyzeo.com>
 * @category Scaleflex
 * @package Scaleflex\Cloudimage
 * @license BSD-3-Clause
 * @copyright Copyright (c) 2021 Cloudimage (https://www.cloudimage.io/)
 */

namespace Scaleflex\Cloudimage\Observer;

use Scaleflex\Cloudimage\Helper\Config;
use Scaleflex\Cloudimage\Helper\Images;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProcessImages implements ObserverInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Images
     */
    private $images;

    /**
     * ProcessImages constructor.
     *
     * @param Config $config
     * @param Images $imagesz
     */
    public function __construct(
        Config $config,
        Images $images
    ) {
        $this->config = $config;
        $this->images = $images;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if (!$this->config->isActive()) {
            return;
        }
        $transport = $observer->getData('transport');
        /** @var \Magento\Framework\View\Element\Template $block */
        $block     = $observer->getData('block');

        if ($this->isIgnoreBlock($block)) {
            return;
        }

        if (stripos($transport->getHtml(), '<img') !== false) {
            $newHtml = $this->images->processHtml($transport->getHtml());
            if ($transport->getHtml() !== $newHtml) {
                $transport->setData('html', $newHtml);
            }
        }
    }

    /**
     * Check ignored block
     * @param $block
     * @return bool
     */
    private function isIgnoreBlock($block)
    {
        $blockName          = $block->getNameInLayout();
        $blockChildNames    = $block->getChildNames();
        $ignoreBlocks       = $this->config->getIgnoreBlocks();

        if (in_array($blockName, $ignoreBlocks)) {
            return true;
        }

        foreach ($blockChildNames as $childName) {
            if (in_array($childName, $ignoreBlocks)) {
                return true;
            }
        }

        return false;
    }
}

<?php

namespace Cloudimage\Responsive\Observer;

use Cloudimage\Responsive\Helper\Config;
use Cloudimage\Responsive\Helper\Images;
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
     * @param Images $images
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
        if (stripos($transport->getHtml(), '<img ') !== false) {
            $newHtml = $this->images->processHtml($transport->getHtml());
            if ($transport->getHtml() !== $newHtml) {
                $transport->setData('html', $newHtml);
            }
        }
    }
}

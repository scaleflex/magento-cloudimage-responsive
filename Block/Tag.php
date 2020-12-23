<?php
/**
 * This file is part of CloudImage Responsive
 *
 * @author Alyzeo LTD <info@alyzeo.com>
 * @category CloudImage
 * @package CloudImage\Responsive\Block
 * @license BSD-3-Clause
 * @copyright Copyright (c) 2021 Cloudimage (https://www.cloudimage.io/)
 */

namespace CloudImage\Responsive\Block;

use CloudImage\Responsive\Helper\Config;
use Magento\Framework\View\Element\Template;
use Zend\Json\Json;

class Tag extends Template
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Config $config,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return bool
     */
    public function isInvalidToken()
    {
        return empty($this->config->getToken());
    }

    /**
     * Get CloudImage Responsive plugin config
     *
     * @return string
     */
    public function getJsonConfig()
    {
        return Json::encode($this->config->getConfiguration());
    }

    /**
     * @return bool
     */
    public function isLazyLoadingActive()
    {
        return $this->config->isLazyLoading();
    }
}

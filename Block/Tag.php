<?php
/**
 * This file is part of Cloudimage Responsive
 *
 * @author Alyzeo LTD <info@alyzeo.com>
 * @category Cloudimage
 * @package Cloudimage\Responsive\Block
 * @license BSD-3-Clause
 * @copyright Copyright (c) 2021 Cloudimage (https://www.cloudimage.io/)
 */

namespace Cloudimage\Responsive\Block;

use Cloudimage\Responsive\Helper\Config;
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
     * Get Cloudimage Responsive plugin config
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

<?php
/**
 * This file is part of Cloudimage Responsive
 *
 * @author Alyzeo LTD <info@alyzeo.com>
 * @category Cloudimage
 * @package Cloudimage\Responsive
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

    /**
     * Tag constructor.
     *
     * @param Config $config
     * @param Template\Context $context
     * @param array $data
     */
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
     * @return string
     */
    public function getConfigToString(): string
    {
        $config = ' ';
        if ($this->config->isLazyLoading()) {
            $config .= 'lazyLoading:true, ';
        }
        if ($this->config->isDoNotReplaceUrl()) {
            $config .= 'doNotReplaceURL:true, ';
        }
        if ($this->config->isIgnoreNodeImgSize()) {
            $config .= 'ignoreNodeImgSize:true, ';
        }
        if ($this->config->isIgnoreStyleImgSize()) {
            $config .= 'ignoreStyleImgSize:true, ';
        }
        if ($this->config->isCustomFunctionActive()) {
            $config .= 'processQueryString: function (props) ' . $this->config->getCustomFunction() . ', ';
        }
        $config .= 'token:\'' . $this->config->getToken() . '\' ';
        return $config;
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

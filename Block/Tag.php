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

namespace Scaleflex\Cloudimage\Block;

use Scaleflex\Cloudimage\Helper\Config;
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
        if (!empty($this->config->getCName())) {
            $config .= 'customDomain: true, ';
            $config .= "domain: '{$this->config->getCName()}', ";
        }
        if ($this->config->isRemoveV7()) {
            $config .= 'apiVersion:null, ';
        }
        if ($this->config->isCustomFunctionActive()) {
            $config .= 'processQueryString: function (props) ' . $this->config->getCustomFunction() . ', ';
        }
        $config .= 'devicePixelRatioList: ' . $this->formatRatioList($this->config->getDevicePixelRatio()) . ', ';
        if ($this->config->isOrgIfSml()) {
            $config .= "params: 'org_if_sml=1&".$this->config->getLibraryOptions()."', ";
        } else {
            if ($this->config->getLibraryOptions()) {
                $config .= "params: '".$this->config->getLibraryOptions()."', ";
            }
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
     * Get Scaleflex Cloudimage plugin config
     *
     * @return string
     */
    public function getJsonConfig()
    {
        return Json::encode($this->config->getConfiguration());
    }

    public function getLibraryOptions()
    {
        return $this->config->getLibraryOptions();
    }

    /**
     * @return bool
     */
    public function isLazyLoadingActive()
    {
        return $this->config->isLazyLoading();
    }

    /** @return string */
    public function formatRatioList($pixelRatio)
    {
        $ratioList = '[]';
        switch ($pixelRatio) {
            case '1':
                $ratioList = '[1]';
                break;
            case '1.5':
                $ratioList = '[1, 1.5]';
                break;
            case '2':
                $ratioList = '[1, 1.5, 2]';
                break;
        }
        return $ratioList;
    }
}

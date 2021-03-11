<?php
/**
 * This file is part of Cloudimage Responsive
 *
 * @author Alyzeo LTD <info@alyzeo.com>
 * @category Cloudimage
 * @package Cloudimage\Responsive\Model
 * @license BSD-3-Clause
 * @copyright Copyright (c) 2021 Cloudimage (https://www.cloudimage.io/)
 */

namespace Cloudimage\Responsive\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const XML_PATH_CLOUDIMAGE_RESPONSIVE_GENERAL_ACTIVE = 'cloudimage_responsive/general/active';
    const XML_PATH_CLOUDIMAGE_RESPONSIVE_GENERAL_TOKEN = 'cloudimage_responsive/general/token';
    const XML_PATH_CLOUDIMAGE_RESPONSIVE_OPTIONS_LAZY_LOADING = 'cloudimage_responsive/options/lazy_loading';
    const XML_PATH_CLOUDIMAGE_RESPONSIVE_OPTIONS_IGNORE_NODE_IMG_SIZE = 'cloudimage_responsive/options/ignore_node_img_size';
    const XML_PATH_CLOUDIMAGE_RESPONSIVE_OPTIONS_IGNORE_STYLE_IMG_SIZE = 'cloudimage_responsive/options/ignore_style_img_size';
    const XML_PATH_CLOUDIMAGE_RESPONSIVE_OPTIONS_DO_NOT_REPLACE_URL = 'cloudimage_responsive/options/do_not_replace_url';
    const XML_PATH_CLOUDIMAGE_RESPONSIVE_CDN_API_URL = 'cloudimage_responsive/cdn/api_url';
    const XML_PATH_CLOUDIMAGE_RESPONSIVE_ADVANCED_CUSTOM_FUNCTION_ACTIVE = 'cloudimage_responsive/advanced/custom_function_active';
    const XML_PATH_CLOUDIMAGE_RESPONSIVE_ADVANCED_CUSTOM_FUNCTION = 'cloudimage_responsive/advanced/custom_function';

    /**
     * @return bool
     */
    public function getApiUrl()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CLOUDIMAGE_RESPONSIVE_CDN_API_URL);
    }

    /**
     * Get Token
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CLOUDIMAGE_RESPONSIVE_GENERAL_TOKEN,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * Get Cloudimage Responsive plugin configuration
     *
     * @return array
     */
    public function getConfiguration()
    {
        $data['token'] = $this->getToken();
        if ($this->isDoNotReplaceUrl()) {
            $data['doNotReplaceURL'] = true;
        }
        if ($this->isIgnoreNodeImgSize()) {
            $data['ignoreNodeImgSize'] = true;
        }
        if ($this->isIgnoreStyleImgSize()) {
            $data['ignoreStyleImgSize'] = true;
        }
        if ($this->isLazyLoading()) {
            $data['lazyLoading'] = true;
        }
        return $data;
    }

    /**
     * Is custom function active
     *
     * @return bool
     */
    public function getCustomFunction()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CLOUDIMAGE_RESPONSIVE_ADVANCED_CUSTOM_FUNCTION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Is Active
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CLOUDIMAGE_RESPONSIVE_GENERAL_ACTIVE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get custom function
     *
     * @return bool
     */
    public function isCustomFunctionActive()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CLOUDIMAGE_RESPONSIVE_ADVANCED_CUSTOM_FUNCTION_ACTIVE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isDoNotReplaceUrl()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CLOUDIMAGE_RESPONSIVE_OPTIONS_DO_NOT_REPLACE_URL,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function isIgnoreNodeImgSize()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CLOUDIMAGE_RESPONSIVE_OPTIONS_IGNORE_NODE_IMG_SIZE,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function isIgnoreStyleImgSize()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CLOUDIMAGE_RESPONSIVE_OPTIONS_IGNORE_STYLE_IMG_SIZE,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * Get Lazy Loading
     *
     * @return bool
     */
    public function isLazyLoading()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CLOUDIMAGE_RESPONSIVE_OPTIONS_LAZY_LOADING,
            ScopeInterface::SCOPE_WEBSITE
        );
    }
}

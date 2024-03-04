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

namespace Scaleflex\Cloudimage\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 *
 * @package Scaleflex\Cloudimage\Helper
 */
class Config extends AbstractHelper
{
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_GENERAL_ACTIVE = 'scaleflex_cloudimage/general/active';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_GENERAL_TOKEN = 'scaleflex_cloudimage/general/token';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_GENERAL_CNAME = 'scaleflex_cloudimage/general/cname';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_LAZY_LOADING = 'scaleflex_cloudimage/options/lazy_loading';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_IGNORE_NODE_IMG_SIZE = 'scaleflex_cloudimage/options/ignore_node_img_size';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_PRERENDER = 'scaleflex_cloudimage/options/prerender';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_IGNORE_STYLE_IMG_SIZE = 'scaleflex_cloudimage/options/ignore_style_img_size';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_DO_NOT_REPLACE_URL = 'scaleflex_cloudimage/options/do_not_replace_url';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_CDN_API_URL = 'scaleflex_cloudimage/cdn/api_url';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_CUSTOM_FUNCTION_ACTIVE = 'scaleflex_cloudimage/advanced/custom_function_active';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_CUSTOM_FUNCTION = 'scaleflex_cloudimage/advanced/custom_function';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_IMAGE_QUALITY = 'scaleflex_cloudimage/advanced/image_quality';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_PROCESS_SVG = 'scaleflex_cloudimage/advanced/ignore_svg';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_LIBRARY_OPTIONS = 'scaleflex_cloudimage/advanced/library_options';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_REMOVE_V7 = 'scaleflex_cloudimage/advanced/remove_v7';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_FOTORAMA_COMPATIBILITY = 'scaleflex_cloudimage/advanced/fortorama_compatibility';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_DEVICEPIXELRATIO = 'scaleflex_cloudimage/advanced/devicepixelratio';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_ORG_IF_SML = 'scaleflex_cloudimage/advanced/orgifsml';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_IGNORE_BLOCKS = 'scaleflex_cloudimage/advanced/ignore_blocks';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_IGNORE_HTML_ID_ACTIVATE = 'scaleflex_cloudimage/advanced/ignore_html_id_active';
    const XML_PATH_SCALEFLEX_CLOUDIMAGE_IGNORE_HTML_IDS = 'scaleflex_cloudimage/advanced/ignore_html_ids';

    /**
     * @return bool
     */
    public function getApiUrl()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SCALEFLEX_CLOUDIMAGE_CDN_API_URL, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Token
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_GENERAL_TOKEN,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Cname
     *
     * @return mixed
     */
    public function getCName()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_GENERAL_CNAME,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Token
     *
     * @return string
     */
    public function buildUrl($inputUrl)
    {
        if (!empty($this->getCName())) {
            $baseUrl = "//" . $this->getCName() . "/";
        } else {
            $baseUrl = "//" . $this->getToken() . ".cloudimg.io/";
        }

        if (!$this->isRemoveV7()) {
            $baseUrl .= "v7/";
        }

        $flagCheck = false;

        $ciUrl = $baseUrl . $inputUrl . "?";

        if ($this->getImageQuality() < 100) {
            if (!strpos($ciUrl, "?q=" . $this->getImageQuality())) {
                $ciUrl .= "q=" . $this->getImageQuality();
            }
            $flagCheck = true;
        }

        if ($this->isOrgIfSml()) {
            $configParam = "org_if_sml=1";
            if (!strpos($ciUrl, $configParam)) {

                if (substr($ciUrl, -1) === $this->getImageQuality() . '?') {
                    $ciUrl = substr($ciUrl, 0, -1);
                }
                $ciUrl .= $flagCheck ? "&" . $configParam : $configParam;
            }
            $flagCheck = true;
        }

        $finalUrl = $flagCheck ? $ciUrl : $baseUrl . $inputUrl;

        return $finalUrl;
    }

    /**
     * Get ignore blocks
     *
     * @return array
     */
    public function getIgnoreBlocks()
    {
        $ignoreList = [];
        $ignoreBlocks = $this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_IGNORE_BLOCKS,
            ScopeInterface::SCOPE_STORE
        );
        if (!empty($ignoreBlocks)) {
            $ignoreBlocks = trim($ignoreBlocks);
            $explodedBlocks = explode(",", $ignoreBlocks);
            foreach ($explodedBlocks as $item) {
                $ignoreList[] = trim($item);
            }
        }

        return $ignoreList;
    }

    public function getIgnoreHtmlIds()
    {
        $ignoreList = [];

        if ($this->isIgnoreHtmlIdActive()) {
            $ignoreHtmlIds = $this->scopeConfig->getValue(
                self::XML_PATH_SCALEFLEX_CLOUDIMAGE_IGNORE_HTML_IDS,
                ScopeInterface::SCOPE_STORE
            );
            if (!empty($ignoreHtmlIds)) {
                $ignoreHtmlIds = trim($ignoreHtmlIds);
                $explodedHtmlIds = explode(",", $ignoreHtmlIds);
                foreach ($explodedHtmlIds as $item) {
                    $ignoreList[] = trim($item);
                }
            }
        }

        return $ignoreList;
    }

    /**
     * Get Scaleflex Cloudimage plugin configuration
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
     * Get custom function
     *
     * @return bool
     */
    public function getCustomFunction()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_CUSTOM_FUNCTION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Image Quality
     *
     * More info here: https://docs.cloudimage.io/go/cloudimage-documentation-v7/en/image-compression/image-formats
     * @return int
     */
    public function getImageQuality()
    {
        $imageQuality = (int)$this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_IMAGE_QUALITY,
            ScopeInterface::SCOPE_STORE
        );
        if ($imageQuality > 0 && $imageQuality <= 100) {
            return $imageQuality;
        }
        return 100;
    }

    /**
     * Get Library Options
     *
     * @return string
     */
    public function getLibraryOptions()
    {
        $options = $this->scopeConfig->getValue(self::XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_LIBRARY_OPTIONS, ScopeInterface::SCOPE_STORE);
        if (is_string($options) && strlen(trim($options)) > 0) {
            return trim($options);
        }
        return '';
    }

    /**
     * Is Active
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_GENERAL_ACTIVE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Is Ignore HTML ID Active
     *
     * @return bool
     */
    public function isIgnoreHtmlIdActive()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_IGNORE_HTML_ID_ACTIVATE,
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
        $isCustomFunctionActive = (bool)$this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_CUSTOM_FUNCTION_ACTIVE,
            ScopeInterface::SCOPE_STORE
        );

        if ($isCustomFunctionActive) {
            $customFunction = $this->getCustomFunction();
            if (is_string($customFunction) && strlen(trim($customFunction)) > 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isDoNotReplaceUrl()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_DO_NOT_REPLACE_URL,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isIgnoreNodeImgSize()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_IGNORE_NODE_IMG_SIZE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isIgnoreStyleImgSize()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_IGNORE_STYLE_IMG_SIZE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isOrgIfSml()
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_ORG_IF_SML,
            ScopeInterface::SCOPE_STORE
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
            self::XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_LAZY_LOADING,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Ignore SVG images ?
     *
     * @return bool
     */
    public function isIgnoreSvg()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_PROCESS_SVG, ScopeInterface::SCOPE_STORE);
    }


    /**
     * Device pixel ratio
     *
     * @return string
     */
    public function getDevicePixelRatio()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_DEVICEPIXELRATIO, ScopeInterface::SCOPE_STORE);
    }


    /**
     * Prerender support
     *
     * @return bool
     */
    public function getPrerender()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SCALEFLEX_CLOUDIMAGE_OPTIONS_PRERENDER, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Ignore SVG images ?
     *
     * @return bool
     */
    public function isRemoveV7()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_REMOVE_V7, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isFotoramaCompatibility()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SCALEFLEX_CLOUDIMAGE_ADVANCED_FOTORAMA_COMPATIBILITY, ScopeInterface::SCOPE_STORE);
    }
}

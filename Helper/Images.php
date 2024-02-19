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

use domDocument;
use DOMElement;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
 * Class Images
 * @package Scaleflex\Cloudimage\Helper
 */
class Images extends AbstractHelper
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Config  $config,
        Context $context
    )
    {
        parent::__construct($context);
        $this->config = $config;
    }

    /**
     * Process html and replace image src attribute with ci-src
     *
     * @param $html
     * @return string
     */
    public function processHtml($html)
    {
        if (stripos($html, '<img') !== false) {
            $dom = new domDocument();
            $useErrors = libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
            libxml_use_internal_errors($useErrors);
            $dom->preserveWhiteSpace = false;
            $replaceHtml = false;

            $quality = '';
            if ($this->config->getImageQuality() < 100) {
                $quality = '?q=' . $this->config->getImageQuality();
            }
            $ignoreSvg = $this->config->isIgnoreSvg();

            foreach ($dom->getElementsByTagName('img') as $element) {
                /** @var DOMElement $element */
                if ($element->hasAttribute('src')) {

                    if ($this->config->getPrerender()) {
                        if ($element->hasAttribute('data-lazy-off')
                            || strpos($element->getAttribute('class'), 'lazy-off') !== false) {
                            continue;
                        }
                        if ($ignoreSvg && strtolower(pathinfo($element->getAttribute('src'), PATHINFO_EXTENSION)) === 'svg') {
                            continue;
                        }

                        $imageSrc = $element->getAttribute('src') . $quality;

                        if (!empty($this->config->getCName())) {
                            if (!stripos($imageSrc, $this->config->getCName())) {
                                $ciSrc = $this->config->buildUrl($imageSrc);
                                $element->setAttribute('src', $ciSrc);
                            }
                        } else {
                            if (!stripos($imageSrc, $this->config->getToken())) {
                                $ciSrc = $this->config->buildUrl($imageSrc);
                                $element->setAttribute('src', $ciSrc);
                            }
                        }
                    } else {
                        if ($element->hasAttribute('data-lazy-off')
                            || strpos($element->getAttribute('class'), 'lazy-off') !== false) {
                            continue;
                        }
                        if ($ignoreSvg && strtolower(pathinfo($element->getAttribute('src'), PATHINFO_EXTENSION)) === 'svg') {
                            continue;
                        }
                        $element->setAttribute('ci-src', $element->getAttribute('src') . $quality);
                        $element->removeAttribute('src');
                    }


                    $replaceHtml = true;
                }
            }

            if ($replaceHtml) {
                $html = $dom->saveHTML($dom->documentElement);
                $html = str_ireplace(['<html><body>', '</body></html>'], '', $html);
            }
        }
        return $html;
    }
}

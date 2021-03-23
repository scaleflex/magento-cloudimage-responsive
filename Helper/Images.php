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

namespace Cloudimage\Responsive\Helper;

use domDocument;
use DOMElement;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Images
 * @package Cloudimage\Responsive\Helper
 */
class Images extends AbstractHelper
{

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

            foreach ($dom->getElementsByTagName('img') as $element) {
                /** @var DOMElement $element */
                if ($element->hasAttribute('src')) {
                    $element->setAttribute('ci-src', $element->getAttribute('src'));
                    $element->removeAttribute('src');
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

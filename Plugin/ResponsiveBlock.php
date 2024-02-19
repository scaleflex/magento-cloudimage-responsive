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

namespace Scaleflex\Cloudimage\Plugin;

use Scaleflex\Cloudimage\Helper\Config;
use Scaleflex\Cloudimage\Helper\Images;

class ResponsiveBlock
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Images
     */
    private $helper;

    public function __construct(
        Config $config,
        Images $images
    )
    {
        $this->config = $config;
        $this->images = $images;
    }

    public function process($html)
    {
        if (!$this->config->isActive()) {
            return $html;
        }
        return $this->images->processHtml($html);
    }
}

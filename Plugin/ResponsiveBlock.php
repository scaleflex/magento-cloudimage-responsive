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

namespace Cloudimage\Responsive\Plugin;

use Cloudimage\Responsive\Helper\Config;
use Cloudimage\Responsive\Helper\Images;

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
    ) {
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

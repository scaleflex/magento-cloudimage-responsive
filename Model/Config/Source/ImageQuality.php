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

namespace Scaleflex\Cloudimage\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ImageQuality implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        for ($i = 100; $i > 0; $i--) {
            $options[] = ['value' => $i, 'label' => $i];
        }
        return $options;
    }
}

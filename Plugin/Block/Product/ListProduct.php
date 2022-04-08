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

namespace Scaleflex\Cloudimage\Plugin\Block\Product;

use Scaleflex\Cloudimage\Plugin\ResponsiveBlock;
use Magento\Catalog\Block\Product\ListProduct as ProductList;

class ListProduct extends ResponsiveBlock
{

    public function afterToHtml(ProductList $subject, $result)
    {
        return $this->process($result);
    }
}

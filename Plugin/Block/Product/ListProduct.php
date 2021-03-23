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

namespace Cloudimage\Responsive\Plugin\Block\Product;

use Cloudimage\Responsive\Plugin\ResponsiveBlock;
use Magento\Catalog\Block\Product\ListProduct as ProductList;

class ListProduct extends ResponsiveBlock
{

    public function afterToHtml(ProductList $subject, $result)
    {
        return $this->process($result);
    }
}

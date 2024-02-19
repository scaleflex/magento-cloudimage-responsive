<?php

namespace Scaleflex\Cloudimage\Model\Config\Source;

class PixelRatio implements \Magento\Framework\Data\OptionSourceInterface
{

    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => __('1')],
            ['value' => '1.5', 'label' => __('1.5')],
            ['value' => '2', 'label' => __('2')]
        ];
    }
}

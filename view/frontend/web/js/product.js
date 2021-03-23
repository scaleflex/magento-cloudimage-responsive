/**
 * This file is part of Cloudimage Responsive
 *
 * @author Alyzeo LTD <info@alyzeo.com>
 * @category Cloudimage
 * @package Cloudimage\Responsive
 * @license BSD-3-Clause
 * @copyright Copyright (c) 2021 Cloudimage (https://www.cloudimage.io/)
 */
define(['jquery', 'mage/gallery/gallery'], function($, gallery) {
    $('[data-gallery-role=gallery-placeholder]').on('gallery:loaded', function () {
        $(this).on('fotorama:load', function (e, fotorama, extra) {
            if (extra.frame.type === 'image') {
                let img = '<img ci-src="'+extra.frame.img+'" class="fotorama__img" aria-hidden="false">';
                extra.frame.$stageFrame.html(img);
            }
            window.ciResponsive.process();
        });
    });
});

/**
 * This file is part of Scaleflex Cloudimage
 *
 * @author Alyzeo LTD <info@alyzeo.com>
 * @category Scaleflex
 * @package Scaleflex\Cloudimage
 * @license BSD-3-Clause
 * @copyright Copyright (c) 2021 Cloudimage (https://www.cloudimage.io/)
 */
define([
    'jquery',
    'mage/gallery/gallery'
], function ($, gallery) {
    'use strict';

    return function () {
        $('[data-gallery-role=gallery-placeholder]').on('gallery:loaded', function () {
            $(this).on('fotorama:load', function (e, fotorama, extra) {
                if (extra.frame.type === 'image') {
                    if (window.ciPrerender) {
                        let img = '<img src="' + window.ciPreUrl + extra.frame.img + '" class="fotorama__img" aria-hidden="false">';
                        extra.frame.$stageFrame.html(img);
                    } else {
                        let img = '<img ci-src="' + extra.frame.img + '" class="fotorama__img" aria-hidden="false">';
                        extra.frame.$stageFrame.html(img);
                    }
                }

                if (!window.ciPrerender) {
                    window.ciResponsive.process();
                }
            });
        });
    }
});
